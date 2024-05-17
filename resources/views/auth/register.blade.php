<x-app-layout>
    <div class="bg-white dark:bg-gray-900 p-8 rounded-lg shadow-lg max-w-md w-full">
        <form action="{{ route('register') }}" method="POST">
            @csrf


            <div class="mb-4">
                <label for="username"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2 form-control @error('name') is-invalid @enderror">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') is-invalid @enderror">
                @error('username')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>


            <div class="mb-4">
                <label for="email"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-1">
                <label for="password"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="password_confirmation"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('password_confirmation')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="role" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Role</label>
                <select id="role" name="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option>Client</option>
                    <option>Business</option>
                </select>

            </div>
            <div class="flex items-center justify-between mt-4">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white font-bold py-2 px-4 rounded-md focus:shadow-outline">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
