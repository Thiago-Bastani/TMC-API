<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $pending = User::where('status', 'pending')
                       ->where('is_admin', false)
                       ->orderBy('created_at')
                       ->get();

        return view('dashboard', compact('pending'));
    }

    public function approve(int $id)
    {
        User::where('id', $id)->where('is_admin', false)->update(['status' => 'approved']);

        return back()->with('success', 'User approved.');
    }

    public function reject(int $id)
    {
        User::where('id', $id)->where('is_admin', false)->update(['status' => 'rejected']);

        return back()->with('success', 'User rejected.');
    }
}
