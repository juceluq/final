<x-app-layout>
    <div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">

        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Verify Your Email Address</h5>
        @if (session('resent'))
                <x-alert type="success" title="Success!">A fresh verification link has been sent to your email address.</x-alert>
        @endif
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Before proceeding, please check your
            email for a verification link. <br>
            If you did not receive the email,</p>

        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">click here to request another</button>
        </form>
    </div>
</x-app-layout>
