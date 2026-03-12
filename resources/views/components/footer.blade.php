<footer class="relative bg-black text-white py-16 overflow-hidden">
    <!-- Animated background pattern -->
    <div class="absolute inset-0 opacity-10 animated-pattern"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="text-3xl font-bold tracking-tighter text-white mb-6 block">
                    V E L O U R
                </a>
                <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                    Meningkatkan kebutuhan sehari-hari dengan gerakan dinamis dan keanggunan modern. Didesain untuk yang berani dan mempesona.
                </p>
                <!-- Social Links with Hover Scale -->
                <div class="flex space-x-4">
                    @foreach(['Twitter', 'Instagram', 'Facebook', 'Pinterest'] as $social)
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-indigo-600 transition-all duration-300 hover:scale-110">
                            <!-- Placeholder icon -->
                            <span class="text-xs">{{ substr($social, 0, 1) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-lg font-semibold tracking-wide uppercase mb-6">Belanja</h4>
                <ul class="space-y-4">
                    @foreach(['Produk Baru', 'Terlaris', 'Wanita', 'Pria', 'Aksesori'] as $link)
                        <li>
                            <a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors duration-300 text-sm flex items-center group">
                                <span class="w-0 h-px bg-indigo-500 mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-2"></span>
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold tracking-wide uppercase mb-6">Dukungan</h4>
                <ul class="space-y-4">
                    @foreach(['FAQ', 'Pengiriman & Pengembalian', 'Lacak Pesanan', 'Hubungi Kami', 'Panduan Ukuran'] as $link)
                        <li>
                            <a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors duration-300 text-sm flex items-center group">
                                <span class="w-0 h-px bg-indigo-500 mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-2"></span>
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-lg font-semibold tracking-wide uppercase mb-6">Buletin</h4>
                <p class="text-sm text-gray-400 mb-4">
                    Berlangganan untuk menerima pembaruan, akses ke penawaran eksklusif, dan banyak lagi.
                </p>
                <form class="flex flex-col space-y-3">
                    <input 
                        type="email" 
                        placeholder="Masukkan alamat email Anda" 
                        class="px-4 py-3 bg-gray-900 text-white placeholder-gray-500 border border-gray-800 focus:outline-none focus:border-indigo-500 transition-colors duration-300 w-full"
                    />
                    <button class="px-6 py-3 bg-white text-black font-semibold uppercase tracking-wider text-sm hover:bg-indigo-600 hover:text-white transition-all duration-300">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-gray-800 text-center md:flex md:justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Velour Fashion. Hak Cipta Dilindungi.</p>
            <div class="mt-4 md:mt-0 flex space-x-6 justify-center">
                <a href="#" class="hover:text-white transition-colors duration-300">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors duration-300">Syarat Layanan</a>
            </div>
        </div>
    </div>
</footer>

<style>
@keyframes bgMove {
    0% { background-position: 0% 0%; }
    100% { background-position: 100% 100%; }
}
.animated-pattern {
    background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
    background-size: 32px 32px;
    animation: bgMove 20s linear infinite;
}
</style>
