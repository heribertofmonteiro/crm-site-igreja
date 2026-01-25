<?php

namespace App\Http\Controllers;

use App\Models\ChurchEvent;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChurchEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:church_events.view')->only(['index', 'show']);
        $this->middleware('permission:church_events.create')->only(['create', 'store']);
        $this->middleware('permission:church_events.edit')->only(['edit', 'update']);
        $this->middleware('permission:church_events.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = ChurchEvent::paginate(10);
        return view('admin.church_events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.church_events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        ChurchEvent::create($request->all());

        return redirect()->route('admin.church_events.index')
            ->with('success', 'Evento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChurchEvent $event)
    {
        $registrations = $event->registrations;
        return view('admin.church_events.show', compact('event', 'registrations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChurchEvent $event)
    {
        return view('admin.church_events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChurchEvent $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.church_events.index')
            ->with('success', 'Evento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChurchEvent $event)
    {
        $event->delete();

        return redirect()->route('admin.church_events.index')
            ->with('success', 'Evento removido com sucesso.');
    }

    /**
     * Show the registration form for a public event.
     */
    public function register($id)
    {
        $event = ChurchEvent::findOrFail($id);
        return view('public.events.register', compact('event'));
    }

    /**
     * Store a new registration for the event.
     */
    public function storeRegistration(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'confirmed' => 'required|boolean',
        ]);

        $event = ChurchEvent::findOrFail($id);

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'confirmed' => $request->confirmed,
        ]);

        // Enviar email de confirmação
        Mail::to($request->email)->send(new \App\Mail\EventRegistrationConfirmation($registration));

        return redirect()->back()->with('success', 'Inscrição realizada com sucesso! Verifique seu email para confirmação.');
    }
}
