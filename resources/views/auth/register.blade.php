<x-app-layout>
    <div class="bg-white dark:bg-gray-900 p-8 rounded-lg shadow-lg max-w-md w-full">

        <form method="POST" action="{{ route('register') }}">
            @csrf
            {{-- TODO Name input --}}
            <div class="row mb-3">
                <label for="name" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Name</label>

                <div class="col-md-6">
                    <input id="name" type="text"
                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback " role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            {{-- TODO Username input --}}
            <div class="row mb-3">
                <label for="username"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Username</label>

                <div class="col-md-6">
                    <input id="username" type="text"
                        class=" shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback text-red-800 dark:text-red-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- TODO Email input --}}
            <div class="row mb-3">
                <label for="email"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Email</label>

                <div class="col-md-6">
                    <input id="email" type="email"
                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback text-red-800 dark:text-red-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- TODO Password input --}}
            <div class="row mb-3">
                <label for="password"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback text-red-800 dark:text-red-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- TODO Password-confirm input --}}
            <div class="row mb-3">
                <label for="password-confirm"
                    class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password"
                        class=" shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control"
                        name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            {{-- TODO Role Selection --}}
            <div class="row mb-3">
                <label for="role" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Role</label>
                <div class="col-md-6">
                    <select id="role" name="role"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white form-control @error('role') is-invalid @enderror"
                        required>
                        <option value="">Select a Role</option>
                        <option value="Client">Client</option>
                        <option value="Business">Business</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="text-sm mt-4 mb-2">
                <p class="text-gray-800 dark:text-gray-200">Already registered? <a href="/login"
                        class="text-indigo-600 hover:text-indigo-800 dark:hover:text-indigo-400">Login</a></p>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit"
                        class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white font-bold py-2 px-4 rounded-md focus:shadow-outline">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
