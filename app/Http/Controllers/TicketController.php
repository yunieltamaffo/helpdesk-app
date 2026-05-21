<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = $user->isAdmin() || $user->isTechnicien()
            ? Ticket::with('user')
            : Ticket::where('user_id', $user->id);

        if (request('status'))
            $query->where('status', request('status'));
        if (request('priority'))
            $query->where('priority', request('priority'));
        if (request('category'))
            $query->where('category', request('category'));

        $tickets = $query->latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:reseau,materiel,logiciel,acces,autre',
            'priority' => 'required|in:basse,moyenne,haute,urgente',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'ouvert',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket créé avec succès !');
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);
        $comments = $ticket->comments()->with('user')->latest()->get();
        return view('tickets.show', compact('ticket', 'comments'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorizeTicket($ticket);
        $user = auth()->user();

        if ($user->isAdmin() || $user->isTechnicien()) {
            $request->validate([
                'status' => 'required|in:ouvert,en_cours,en_attente,resolu,ferme',
            ]);
            $ticket->update(['status' => $request->status]);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|in:reseau,materiel,logiciel,acces,autre',
                'priority' => 'required|in:basse,moyenne,haute,urgente',
            ]);
            $ticket->update($request->only('title', 'description', 'category', 'priority'));
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket mis à jour !');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);
        $ticket->delete();
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket supprimé !');
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Commentaire ajouté !');
    }

    private function authorizeTicket(Ticket $ticket)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isTechnicien() && $ticket->user_id !== $user->id) {
            abort(403);
        }
    }
}