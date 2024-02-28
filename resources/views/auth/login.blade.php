<x-guest-layout>
    <div class="bg-gray-900 text-white">
        <div class="container mx-auto p-8 bg-gray-800 rounded-md shadow-md">
            <h2 class="text-3xl font-bold mb-8">ログイン</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-300">Email</label>
                    <input id="email" type="email" name="email" required autofocus autocomplete="username" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2" :value="old('email')" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2" />
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <label for="remember_me" class="inline-flex items-center text-gray-300">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2">ログイン情報を記憶する</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('パスワードをお忘れですか？') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
