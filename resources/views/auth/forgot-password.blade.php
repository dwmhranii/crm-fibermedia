<x-guest-layout>
    <div class="w-full max-w-md mx-auto my-auto bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-white/20">
        <div class="mb-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-[#eff6ff] text-[#1E5FA8] flex items-center justify-center text-2xl shadow-sm mb-3">
                <i class="bi bi-key-fill"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Lupa Kata Sandi?</h1>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Masukkan alamat email Anda yang terdaftar, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
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
                        placeholder="nama@fibermediaplay.net"
                        class="block w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1E5FA8]/20 focus:border-[#1E5FA8] transition @error('email') border-red-500 @enderror"
                    >
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-3.5 px-6 rounded-2xl text-white font-bold text-sm tracking-wide shadow-lg shadow-[#1E5FA8]/25 hover:shadow-xl hover:shadow-[#1E5FA8]/40 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 group"
                    style="background: linear-gradient(135deg, #1E5FA8 0%, #2575C0 100%);">
                    <span>Kirim Tautan Reset</span>
                    <i class="bi bi-arrow-right text-base group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <div class="pt-4 text-center">
                <a href="{{ route('login') }}" class="text-xs font-semibold text-[#1E5FA8] hover:text-[#2575C0] hover:underline transition inline-flex items-center gap-1.5">
                    <i class="bi bi-arrow-left"></i> Kembali ke Halaman Masuk
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
