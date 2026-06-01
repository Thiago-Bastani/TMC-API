@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="w-full max-w-sm">
    <h1 class="text-2xl font-bold text-center mb-6">TMC Admin</h1>

    <form method="POST" action="/login" class="bg-gray-800 rounded-xl p-6 space-y-4 shadow-lg">
        @csrf

        <div>
            <label class="block text-sm mb-1 text-gray-300">Username</label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required autofocus
            >
            @error('username')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-300">Password</label>
            <input
                type="password"
                name="password"
                class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
            >
        </div>

        <button
            type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded transition"
        >
            Login
        </button>
    </form>
</div>
@endsection
