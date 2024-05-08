<x-app-layout>
    @if (session('error'))
        <x-alert type='danger' title="Error!">{{ session('error') }}</x-alert>
    @endif

    <div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 dark:text-gray-200 mb-6">Login</h2>
        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                <input type="text" name="username" id="username"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="text-sm text-center text-gray-700 dark:text-gray-300">
                <p>Not registered? <a href="/register"
                        class="text-indigo-600 hover:text-indigo-800 dark:hover:text-indigo-400">Register here</a>
                </p>
            </div>
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>

    </div>

</x-app-layout>
