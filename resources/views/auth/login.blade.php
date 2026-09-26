<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto my-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/15 shadow-2xl overflow-hidden">
            
            {{-- PANEL KIRI: ISP FIBERMEDIA SHOWCASE (Desktop) --}}
            <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-10 relative overflow-hidden bg-gradient-to-br from-[#0a1c33] via-[#0e2747] to-[#1E5FA8]/90 text-white border-r border-white/10">
                {{-- Decorative Light Beams --}}
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-[#38bdf8]/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-[#1E5FA8]/30 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Top Badge --}}
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase bg-emerald-500/15 text-emerald-300 border border-emerald-400/30 backdrop-blur-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 -ml-3"></span>
                        <span>Network Active 24/7</span>
                    </div>

                    <h2 class="text-3xl font-extrabold tracking-tight leading-tight text-white mb-3">
                        Portal Manajemen <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-200 to-white">
                            Fibermedia Play
                        </span>
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Akses khusus administrator dan staf untuk mengelola operasional paket internet, konfigurasi konten, serta layanan pelanggan.
                    </p>
                </div>

                {{-- Middle: Feature Highlights --}}
                <div class="relative z-10 my-8 space-y-4">
                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#1E5FA8] to-[#38bdf8] flex items-center justify-center text-white shrink-0 shadow-md">
                            <i class="bi bi-speedometer2 text-base"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Dedicated Fiber Optic</div>
                            <div class="text-xs text-slate-300">Bandwidth simetris berkecepatan tinggi tanpa hambatan.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#1E5FA8] to-[#38bdf8] flex items-center justify-center text-white shrink-0 shadow-md">
                            <i class="bi bi-shield-lock-fill text-base"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Enterprise Security</div>
                            <div class="text-xs text-slate-300">Proteksi data & enkripsi sesi tersertifikasi industri.</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#1E5FA8] to-[#38bdf8] flex items-center justify-center text-white shrink-0 shadow-md">
                            <i class="bi bi-headset text-base"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">NOC Support 24/7</div>
                            <div class="text-xs text-slate-300">Pemantauan stabilitas jaringan nonstop setiap saat.</div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Status Pill --}}
                <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                    <span class="inline-flex items-center gap-1.5">
                        <i class="bi bi-hdd-network text-sky-400"></i> Server Status: Normal
                    </span>
                    <span class="text-sky-300 font-semibold">v1.2 Secure Access</span>
                </div>
            </div>

            {{-- PANEL KANAN: FORM LOGIN --}}
            <div class="lg:col-span-7 bg-white p-8 sm:p-12 flex flex-col justify-center">
                <div class="max-w-md w-full mx-auto">
                    
                    {{-- Header Form --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-2 lg:hidden">
                            <x-application-logo class="h-9 w-auto" />
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Selamat Datang Kembali 👋
                        </h1>
                        <p class="text-sm text-slate-500 mt-1.5">
                            Silakan masukkan akun Anda untuk mengakses sistem.
                        </p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    {{-- Global Error Alert --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-800 flex items-start gap-2.5">
                            <i class="bi bi-exclamation-triangle-fill text-red-600 text-lg shrink-0 mt-0.5"></i>
                            <div>
                                <div class="font-bold">Gagal Masuk</div>
                                <div class="text-xs mt-0.5 text-red-700">Periksa kembali alamat email dan kata sandi Anda.</div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email Address --}}
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Alamat Email
                            </label>
                            <div class="relative rounded-2xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-envelope-fill text-base"></i>
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="nama@fibermediaplay.net"
                                    class="block w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1E5FA8]/20 focus:border-[#1E5FA8] transition @error('email') border-red-500 @enderror"
                                >
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600 font-medium flex items-center gap-1">
                                    <i class="bi bi-x-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-semibold text-[#1E5FA8] hover:text-[#2575C0] hover:underline transition" href="{{ route('password.request') }}">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative rounded-2xl shadow-sm" x-data="{ showPass: false }">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-shield-lock-fill text-base"></i>
                                </div>
                                <input
                                    id="password"
                                    :type="showPass ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="block w-full pl-10 pr-11 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1E5FA8]/20 focus:border-[#1E5FA8] transition @error('password') border-red-500 @enderror"
                                >
                                <button
                                    type="button"
                                    @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                    title="Tampilkan / Sembunyikan Kata Sandi">
                                    <i class="bi" :class="showPass ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-600 font-medium flex items-center gap-1">
                                    <i class="bi bi-x-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center justify-between pt-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-[#1E5FA8] focus:ring-[#1E5FA8]/30 transition"
                                >
                                <span class="ms-2.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                                    Ingat saya di perangkat ini
                                </span>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-3.5 px-6 rounded-2xl text-white font-bold text-sm tracking-wide shadow-lg shadow-[#1E5FA8]/25 hover:shadow-xl hover:shadow-[#1E5FA8]/40 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 group"
                                style="background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%);">
                                <span>Masuk ke Dashboard</span>
                                <i class="bi bi-arrow-right text-base group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>

                    {{-- Security Footer Note --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-center gap-2 text-xs text-slate-400">
                        <i class="bi bi-shield-check text-emerald-600 text-sm"></i>
                        <span>Koneksi aman terenkripsi TLS/SSL 256-bit</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
