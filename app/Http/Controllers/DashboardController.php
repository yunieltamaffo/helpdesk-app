<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isTechnicien()) {
            $tickets = Ticket::with('user')->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
        }

        $stats = [
            'total'     => $tickets->count(),
            'ouverts'   => $tickets->where('status', 'ouvert')->count(),
            'en_cours'  => $tickets->where('status', 'en_cours')->count(),
            'resolus'   => $tickets->where('status', 'resolu')->count(),
            'urgents'   => $tickets->where('priority', 'urgente')->count(),
        ];

        return view('dashboard', compact('tickets', 'stats'));
    }
}