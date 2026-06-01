@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full max-w-5xl">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold">TMC Admin</h1>
            <p class="text-gray-400 text-sm mt-1">User management</p>
        </div>
        <div class="flex items-center gap-6 text-sm">
            <span class="text-yellow-400 font-medium">{{ $pending->count() }} pending</span>
            <span class="text-green-400 font-medium">{{ $approved->count() }} approved</span>
            <span class="text-red-400 font-medium">{{ $rejected->count() }} rejected</span>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-red-400 transition ml-2">Logout</button>
            </form>
        </div>
    </div>

    {{-- Pending --}}
    <section class="mb-8">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-yellow-400 mb-3 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
            Pending approval
        </h2>

        @if($pending->isEmpty())
            <div class="bg-gray-800 rounded-xl px-6 py-5 text-gray-500 text-sm">No pending registrations.</div>
        @else
            <div class="bg-gray-800 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-700/60 text-gray-400 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="text-left px-4 py-3">Username</th>
                            <th class="text-left px-4 py-3">Profile pic</th>
                            <th class="text-left px-4 py-3">Registered</th>
                            <th class="text-right px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($pending as $user)
                        <tr class="hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 font-medium text-white">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                @if($user->prof_pic)
                                    <a href="{{ $user->prof_pic }}" target="_blank"
                                       class="text-indigo-400 hover:underline text-xs max-w-xs truncate block">
                                        {{ $user->prof_pic }}
                                    </a>
                                @else
                                    <span class="text-gray-600">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <form method="POST" action="/dashboard/approve/{{ $user->id }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-500 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="/dashboard/reject/{{ $user->id }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-700 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition"
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
    </section>

    {{-- Approved --}}
    <section class="mb-8">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-green-400 mb-3 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-green-400"></span>
            Approved users
        </h2>

        @if($approved->isEmpty())
            <div class="bg-gray-800 rounded-xl px-6 py-5 text-gray-500 text-sm">No approved users yet.</div>
        @else
            <div class="bg-gray-800 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-700/60 text-gray-400 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="text-left px-4 py-3">Username</th>
                            <th class="text-left px-4 py-3">Profile pic</th>
                            <th class="text-left px-4 py-3">Registered</th>
                            <th class="text-right px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($approved as $user)
                        <tr class="hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 font-medium text-white">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                @if($user->prof_pic)
                                    <a href="{{ $user->prof_pic }}" target="_blank"
                                       class="text-indigo-400 hover:underline text-xs max-w-xs truncate block">
                                        {{ $user->prof_pic }}
                                    </a>
                                @else
                                    <span class="text-gray-600">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="/dashboard/reject/{{ $user->id }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="border border-red-700 hover:bg-red-700 text-red-400 hover:text-white text-xs font-medium px-3 py-1.5 rounded-lg transition"
                                        onclick="return confirm('Revoke {{ $user->username }}\'s access?')">
                                        Revoke
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- Rejected --}}
    <section>
        <h2 class="text-sm font-semibold uppercase tracking-widest text-red-400 mb-3 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
            Rejected users
        </h2>

        @if($rejected->isEmpty())
            <div class="bg-gray-800 rounded-xl px-6 py-5 text-gray-500 text-sm">No rejected users.</div>
        @else
            <div class="bg-gray-800 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-700/60 text-gray-400 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="text-left px-4 py-3">Username</th>
                            <th class="text-left px-4 py-3">Profile pic</th>
                            <th class="text-left px-4 py-3">Registered</th>
                            <th class="text-right px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach($rejected as $user)
                        <tr class="hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 font-medium text-gray-400">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                @if($user->prof_pic)
                                    <a href="{{ $user->prof_pic }}" target="_blank"
                                       class="text-indigo-400 hover:underline text-xs max-w-xs truncate block">
                                        {{ $user->prof_pic }}
                                    </a>
                                @else
                                    <span class="text-gray-600">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="/dashboard/approve/{{ $user->id }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="border border-green-700 hover:bg-green-700 text-green-400 hover:text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        Re-approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

</div>
@endsection
