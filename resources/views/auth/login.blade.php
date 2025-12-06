<x-guest-layout>

    <div class="absolute top-6 left-6">
        <a href="{{ url('/') }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700
                  bg-white border border-gray-300 rounded-full shadow-sm
                  hover:bg-gray-100 hover:border-gray-400 transition">
            ← Kembali
        </a>
    </div>

    <div class="w-full max-w-4xl mx-4 bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

        <div class="w-full md:w-3/2 px-8 py-10 flex flex-col justify-center">
            <h2 class="text-3xl font-semibold text-gray-800 mb-2">
                Login
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Masuk dengan email dan password akun Anda.
            </p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-gray-400" />
                    <x-text-input id="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 text-sm
                                         focus:border-orange-500 focus:ring-orange-500"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-400" />
                    <x-text-input id="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 text-sm
                                         focus:border-orange-500 focus:ring-orange-500"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-2.5 text-sm font-semibold text-white rounded-full
                                   bg-gradient-to-r from-orange-400 to-red-700
                                   hover:from-orange-700 hover:to-red-800
                                   shadow-md hover:shadow-lg transition">
                        LOGIN
                    </button>
                </div>
            </form>
        </div>

        <div
            class="w-full md:w-1/2 bg-gradient-to-br from-orange-400 via-orange-500 to-red-500 text-white
                    flex flex-col items-center justify-center px-8 py-10 text-center">
            <img src="{{ asset('logo/tabrika-logo.png') }}" class="h-42 w-42" alt="">
            <h2 class="text-2xl font-bold mb-3">
                SELAMAT DATANG
            </h2>
            <p class="text-sm text-red-100 mb-6 max-w-xs">
                Login untuk mengelola dashboard barang
            </p>
        </div>

    </div>
</x-guest-layout>
