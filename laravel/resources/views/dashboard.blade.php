@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Pending Registrations</h1>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="text-sm text-gray-400 hover:text-red-400 transition">Logout</button>
        </form>
    </div>

    @if($pending->isEmpty())
        <div class="bg-gray-800 rounded-xl p-8 text-center text-gray-400">
            No pending registrations.
        </div>
    @else
        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg">
            <table class="w-full text-sm">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="text-left px-4 py-3">Username</th>
                        <th class="text-left px-4 py-3">Profile Pic</th>
                        <th class="text-left px-4 py-3">Registered</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($pending as $user)
                    <tr class="hover:bg-gray-750">
                        <td class="px-4 py-3 font-medium">{{ $user->username }}</td>
                        <td class="px-4 py-3">
                            @if($user->prof_pic)
                                <a href="{{ $user->prof_pic }}" target="_blank" class="text-indigo-400 hover:underline text-xs truncate max-w-xs block">
                                    {{ $user->prof_pic }}
                                </a>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <form method="POST" action="/dashboard/approve/{{ $user->id }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded transition">
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="/dashboard/reject/{{ $user->id }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded transition"
                                    onclick="return confirm('Reject {{ $user->username }}?')">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
