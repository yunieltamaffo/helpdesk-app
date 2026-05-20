<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'   => User::count(),
            'total_tickets' => Ticket::count(),
            'ouverts'       => Ticket::where('status', 'ouvert')->count(),
            'en_cours'      => Ticket::where('status', 'en_cours')->count(),
            'resolus'       => Ticket::where('status', 'resolu')->count(),
            'urgents'       => Ticket::where('priority', 'urgente')->count(),
        ];

        $tickets_recents = Ticket::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'tickets_recents'));
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:employe,technicien,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users')
                         ->with('success', 'Rôle mis à jour avec succès !');
    }
}