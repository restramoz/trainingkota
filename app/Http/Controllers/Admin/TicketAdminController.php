<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['service', 'city'])->latest();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Ticket::count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('admin.tickets.create', compact('services', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'city_id' => 'nullable|exists:cities,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        $validated['ticket_number'] = 'TK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $ticket = Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', "Tiket {$ticket->ticket_number} berhasil dibuat.");
    }

    public function show($id)
    {
        $ticket = Ticket::with(['service', 'city'])->findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('admin.tickets.edit', compact('ticket', 'services', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'city_id' => 'nullable|exists:cities,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', "Tiket {$ticket->ticket_number} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticketNumber = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', "Tiket {$ticketNumber} berhasil dihapus.");
    }

    public function whatsappRedirect($id)
    {
        $ticket = Ticket::with(['service', 'city'])->findOrFail($id);
        $url = $ticket->getWhatsAppUrl();

        return redirect()->away($url);
    }
}
