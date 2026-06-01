@extends('layouts.app')

@section('title', 'Initial Setup')

@section('content')
<div class="w-full max-w-sm">
    <h1 class="text-2xl font-bold text-center mb-2">TMC — First Setup</h1>
    <p class="text-gray-400 text-sm text-center mb-6">Create the admin account to get started.</p>

    <form method="POST" action="/setup" class="bg-gray-800 rounded-xl p-6 space-y-4 shadow-lg">
        @csrf

        <div>
            <label class="block text-sm mb-1 text-gray-300">Username</label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                placeholder="admin"
                class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
            >
            <p class="text-xs text-gray-500 mt-1">Letters, numbers, hyphens and underscores only.</p>
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
            @error('password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-300">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required
            >
        </div>

        <button
            type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded transition"
        >
            Create Admin Account
        </button>
    </form>
</div>
@endsection
