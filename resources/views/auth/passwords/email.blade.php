<x-app-layout>
    <div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 dark:text-gray-200 mb-6">{{ __('Reset Password') }}</h2>
        
        @if (session('status'))
            <div class="alert alert-success mb-4 text-sm text-center text-gray-700 dark:text-gray-300" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email Address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700 @error('email') is-invalid @enderror">
                
                @error('email')
                    <span class="invalid-feedback block mt-1 text-sm text-red-600 dark:text-red-400" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
