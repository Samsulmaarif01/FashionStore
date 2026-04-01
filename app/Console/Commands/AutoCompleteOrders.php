<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Carbon;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:autocomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Selesaikan otomatis pesanan yang sudah 3x24 jam sejak dikirim';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = Carbon::now()->subDays(3);

        $affectedRows = Order::where('status', 'shipped')
            ->whereNotNull('shipped_at')
            ->where('shipped_at', '<=', $threshold)
            ->update([
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ]);

        $this->info("Berhasil mengonfirmasi {$affectedRows} pesanan sebagai Selesai secara otomatis.");
    }
}
