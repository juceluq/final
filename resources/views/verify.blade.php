<x-app-layout>
    <h1>Verify Your Email</h1>
    <p>Please click the link below to verify your email address:</p>
    <a href="{{ url('/verify-email/' . $token) }}">Verify Email</a>
</x-app-layout>
