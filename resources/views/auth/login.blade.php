<x-guest-layout>
    <style>
        .login-card {
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(50px);
        }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-input {
            background-color: #1E293B;
            color: white;
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            border-color: #D49A1C;
            background-color: #243447;
            box-shadow: 0 0 0 4px rgba(212, 154, 28, 0.15);
            transform: translateY(-1px);
            outline: none;
        }

        .form-input::placeholder {
            color: #94A3B8;
        }

        .form-input.is-error {
            border-color: #EF4444;
        }

        .btn-masuk {
            background-color: #D49A1C;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(212, 154, 28, 0.2);
        }

        .btn-masuk:hover {
            background-color: #EAB308;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(212, 154, 28, 0.4);
        }

        .btn-masuk:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(212, 154, 28, 0.2);
        }
    </style>

    {{-- Overlay gelap di atas background kantor --}}
    <div class="fixed inset-0 bg-black/20 z-0"></div>

    {{-- Card Login --}}
    <div class="login-card relative z-10 w-full max-w-md mx-4 my-8 px-8 py-4 rounded-2xl"
         style="background: rgba(248, 250, 252, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.5); box-shadow: 0 10px 40px rgba(0,0,0,0.2);">

        {{-- Logo SINARA --}}
        <div class="text-center mt-5 mb-4 transition-transform duration-300 hover:scale-[1.02]">
            <img src="{{ asset('images/Logosinara.png') }}" alt="Logo SINARA"
                 class="mx-auto w-64 h-auto" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium text-green-800"
                 style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.4);">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2 tracking-wide">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    autofocus
                    autocomplete="username"
                    class="form-input w-full px-4 py-3.5 rounded-lg text-sm {{ $errors->has('email') ? 'is-error' : '' }}"
                >
                @error('email')
                    <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2 tracking-wide">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                    class="form-input w-full px-4 py-3.5 rounded-lg text-sm {{ $errors->has('password') ? 'is-error' : '' }}"
                >
                @error('password')
                    <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center mb-7">
                <input
                    type="checkbox"
                    id="remember_me"
                    name="remember"
                    class="w-4 h-4 mr-2.5 rounded cursor-pointer"
                    style="accent-color: #D49A1C;"
                >
                <label for="remember_me" class="text-sm font-medium text-slate-700 cursor-pointer">
                    Remember me
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-masuk w-full py-4 rounded-lg text-white text-sm font-semibold tracking-widest uppercase">
                MASUK
            </button>
        </form>

        {{-- Footer Logo --}}
        <div class="flex justify-center items-center gap-4 mt-5 pt-6 pb-5"
             style="border-top: 1px solid rgba(0,0,0,0.1);">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kementerian Imigrasi"
                 class="h-16 w-auto transition-all duration-300 hover:scale-110"
                 style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
        </div>

    </div>
</x-guest-layout>