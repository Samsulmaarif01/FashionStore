<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────────

    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalMembers  = User::where('role', 'member')->count();
        $totalMessages = \App\Models\Message::count();
        $recentOrders  = Order::with('user')->latest()->take(5)->get();
        $recentMessages = \App\Models\Message::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalMembers', 'totalMessages', 'recentOrders', 'recentMessages'));
    }

    // ── Products CRUD ─────────────────────────────────────────────────

    public function products()
    {
        $products = Product::with('category_rel')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'discount_start'   => ['nullable', 'date'],
            'discount_end'     => ['nullable', 'date', 'after_or_equal:discount_start'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'url', 'max:500'],
            'badge'        => ['nullable', 'string', 'max:50'],
            'stock'        => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
            'is_trending'  => ['boolean'],
        ]);

        // Handle new category creation
        if (!empty($validated['new_category'])) {
            $newCat = Category::firstOrCreate(
                ['name' => $validated['new_category']],
                ['slug' => Str::slug($validated['new_category'])]
            );
            $validated['category_id'] = $newCat->id;
            $validated['category'] = $newCat->name;
        } elseif (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category'] = $category->name;
        } else {
            return back()->withErrors(['category_id' => 'Kategori harus dipilih atau dibuat baru.'])->withInput();
        }

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_trending'] = $request->has('is_trending');

        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;

        Product::updateOrCreate(['slug' => $validated['slug']], $validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'discount_start'   => ['nullable', 'date'],
            'discount_end'     => ['nullable', 'date', 'after_or_equal:discount_start'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'url', 'max:500'],
            'badge'        => ['nullable', 'string', 'max:50'],
            'stock'        => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
            'is_trending'  => ['boolean'],
        ]);

        // Handle new category creation
        if (!empty($validated['new_category'])) {
            $newCat = Category::firstOrCreate(
                ['name' => $validated['new_category']],
                ['slug' => Str::slug($validated['new_category'])]
            );
            $validated['category_id'] = $newCat->id;
            $validated['category'] = $newCat->name;
        } elseif (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category'] = $category->name;
        } else {
            return back()->withErrors(['category_id' => 'Kategori harus dipilih atau dibuat baru.'])->withInput();
        }

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_trending'] = $request->has('is_trending');
        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }

    // ── Orders ────────────────────────────────────────────────────────

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function printInvoice(Order $order)
    {
        if ($order->payment_method === 'xendit' || $order->status === 'pending') {
            try {
                \Xendit\Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
                $apiInstance = new \Xendit\Invoice\InvoiceApi();
                $invoices = $apiInstance->getInvoices(null, $order->order_number);
                
                if (!empty($invoices) && count($invoices) > 0) {
                    $invoice = $invoices[0];
                    $status = method_exists($invoice, 'getStatus') ? $invoice->getStatus() : ($invoice['status'] ?? null);
                    $paymentMethod = method_exists($invoice, 'getPaymentMethod') ? $invoice->getPaymentMethod() : ($invoice['payment_method'] ?? null);
                    $paymentChannel = method_exists($invoice, 'getPaymentChannel') ? $invoice->getPaymentChannel() : ($invoice['payment_channel'] ?? null);
                    
                    if ($status === 'PAID' || $status === 'SETTLED') {
                        $order->update([
                            'status' => 'processing',
                            'paid_at' => $order->paid_at ?? now(),
                            'payment_method' => $paymentChannel ?? $paymentMethod ?? 'xendit',
                        ]);
                    } elseif ($status === 'EXPIRED') {
                        $order->update([
                            'status' => 'cancelled',
                            'cancel_reason' => 'Invoice expired',
                        ]);
                    } elseif ($paymentMethod || $paymentChannel) {
                        $order->update([
                            'payment_method' => $paymentChannel ?? $paymentMethod
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Ignore API errors
            }
        }

        $order->load(['items.product', 'user']);
        return view('member.invoice', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,shipped,completed,cancelled'],
            'cancel_reason' => ['nullable', 'string', 'max:500']
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'shipped') {
            $data['shipped_at'] = now();
        } elseif ($request->status === 'completed') {
            $data['completed_at'] = now();
        } elseif ($request->status === 'cancelled') {
            $data['cancel_reason'] = $request->cancel_reason;

            if ($order->paid_at) {
                Inbox::create([
                    'user_id' => $order->user_id,
                    'title'   => 'Pesanan Dibatalkan - Refund',
                    'message' => 'Pesanan Anda (' . $order->order_number . ') telah dibatalkan dengan alasan: ' . ($request->cancel_reason ?: 'Dibatalkan oleh Admin') . '. Dana akan di refund manual oleh Velour. Jika 1x24 jam dana tidak dikembalikan, silakan kontak admin Velour.',
                ]);
            }
        }

        $order->update($data);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroyOrder(Order $order)
    {
        $isPaid = $order->paid_at || in_array($order->status, ['processing', 'shipped', 'completed']);

        // Block deletion if paid and NOT completed/cancelled
        if ($isPaid && !in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Pesanan yang sudah dibayar dan masih aktif (diproses/dikirim) tidak bisa dihapus.');
        }

        if ($isPaid) {
            Inbox::create([
                'user_id' => $order->user_id,
                'title'   => 'Pesanan Dihapus - Refund',
                'message' => 'Pesanan Anda (' . $order->order_number . ') telah dihapus dari sistem. Dana akan di refund manual oleh Velour. Jika 1x24 jam dana tidak dikembalikan, silakan kontak admin Velour.',
            ]);
        }

        $order->delete();
        return back()->with('success', 'Riwayat pesanan berhasil dihapus.');
    }

    // ── Members ───────────────────────────────────────────────────────

    public function members()
    {
        $members = User::where('role', 'member')->latest()->paginate(15);
        return view('admin.members', compact('members'));
    }

    // ── About Us ──────────────────────────────────────────────────────

    public function editAbout()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'title' => 'Tentang Kami',
                'content' => 'Selamat datang di Velour.',
            ]);
        }
        return view('admin.about', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $about = About::first();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'url', 'max:500'],
        ]);

        $about->update($validated);

        return back()->with('success', 'Konten Tentang Kami berhasil diperbarui.');
    }

    // ── Analytics & Reports ────────────────────────────────────────────

    public function analytics(Request $request)
    {
        // Date range filter
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Sales summary
        $totalSales = Order::whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrders = Order::whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        $cancelledOrders = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Daily sales for chart
        $dailySales = Order::whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("DATE(created_at) as date, SUM(total_amount) as total")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly sales for chart (SQLite compatible)
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = ['month' => $i, 'total' => 0, 'count' => 0];
        }

        $monthlyResults = DB::table('orders')
            ->whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereRaw("strftime('%Y', created_at) = ?", [now()->year])
            ->selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, SUM(total_amount) as total, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($monthlyResults as $result) {
            $monthlyData[$result->month] = ['month' => (int)$result->month, 'total' => $result->total, 'count' => $result->count];
        }

        $monthlySales = collect(array_values($monthlyData));

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['processing', 'shipped', 'completed'])
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('products.name, products.id, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Sales by category
        $salesByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['processing', 'shipped', 'completed'])
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('categories.name, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        // Order status distribution
        $orderStatuses = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Recent completed orders
        $recentCompletedOrders = Order::with('user')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.analytics', compact(
            'totalSales', 'totalOrders', 'avgOrderValue', 'cancelledOrders',
            'dailySales', 'monthlySales', 'topProducts', 'salesByCategory',
            'orderStatuses', 'recentCompletedOrders', 'startDate', 'endDate'
        ));
    }

    public function exportCSV(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $orders = Order::with('user', 'items.product')
            ->whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $filename = 'laporan_penjualan_' . $startDate . '_' . $endDate . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['Order Number', 'Tanggal', 'Customer', 'Email', 'Total Amount', 'Status', 'Items']);

        // Data rows
        foreach ($orders as $order) {
            $items = $order->items->map(function($item) {
                return $item->product->name . ' (qty: ' . $item->quantity . ')';
            })->implode(', ');

            fputcsv($output, [
                $order->order_number,
                $order->created_at->format('d-m-Y H:i'),
                $order->user->name,
                $order->user->email,
                $order->total_amount,
                $order->status,
                $items
            ]);
        }

        fclose($output);
        exit;
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $totalSales = Order::whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrders = Order::whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $orders = Order::with('user', 'items.product')
            ->whereIn('status', ['processing', 'shipped', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.analytics_pdf', compact(
            'startDate', 'endDate', 'totalSales', 'totalOrders', 'orders'
        ));

        return $pdf->download('laporan_penjualan_' . $startDate . '_' . $endDate . '.pdf');
    }

    // ── Categories CRUD ────────────────────────────────────────────────

    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
