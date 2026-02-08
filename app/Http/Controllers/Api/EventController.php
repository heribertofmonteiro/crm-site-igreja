<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'type' => 'nullable|in:service,meeting,conference,seminar,social',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Event::with(['organizer', 'participants']);

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            if ($request->status === 'upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($request->status === 'ongoing') {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
            } elseif ($request->status === 'completed') {
                $query->where('end_date', '<', now());
            } elseif ($request->status === 'cancelled') {
                $query->where('status', 'cancelled');
            }
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->start_date) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $events = $query->orderBy('start_date')
                        ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Display the specified event
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $event = Event::with(['organizer', 'participants', 'resources'])
                    ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'type' => 'required|in:service,meeting,conference,seminar,social',
            'status' => 'nullable|in:planned,confirmed,cancelled',
            'max_participants' => 'nullable|integer|min:1',
            'organizer_id' => 'required|integer|exists:users,id',
            'participants' => 'nullable|array',
            'participants.*' => 'integer|exists:members,id',
            'resources' => 'nullable|array',
            'resources.*.name' => 'required|string|max:255',
            'resources.*.quantity' => 'required|integer|min:1',
            'resources.*.notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except(['participants', 'resources', 'image']);
        $data['status'] = $data['status'] ?? 'planned';

        $event = Event::create($data);

        // Attach participants
        if ($request->participants) {
            $event->participants()->attach($request->participants);
        }

        // Create resources
        if ($request->resources) {
            foreach ($request->resources as $resource) {
                $event->resources()->create($resource);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event->load(['organizer', 'participants', 'resources'])
        ], 201);
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'type' => 'required|in:service,meeting,conference,seminar,social',
            'status' => 'nullable|in:planned,confirmed,cancelled,completed',
            'max_participants' => 'nullable|integer|min:1',
            'organizer_id' => 'required|integer|exists:users,id',
            'participants' => 'nullable|array',
            'participants.*' => 'integer|exists:members,id',
            'resources' => 'nullable|array',
            'resources.*.name' => 'required|string|max:255',
            'resources.*.quantity' => 'required|integer|min:1',
            'resources.*.notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except(['participants', 'resources', 'image']);

        $event->update($data);

        // Sync participants
        if ($request->participants) {
            $event->participants()->sync($request->participants);
        }

        // Update resources
        if ($request->resources) {
            $event->resources()->delete();
            foreach ($request->resources as $resource) {
                $event->resources()->create($resource);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event->load(['organizer', 'participants', 'resources'])
        ]);
    }

    /**
     * Remove the specified event
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Get event statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $stats = [
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('start_date', '>', now())->count(),
            'ongoing_events' => Event::where('start_date', '<=', now())
                                  ->where('end_date', '>=', now())
                                  ->count(),
            'completed_events' => Event::where('end_date', '<', now())->count(),
            'cancelled_events' => Event::where('status', 'cancelled')->count(),
            'events_this_month' => Event::whereMonth('start_date', now()->month)
                                    ->whereYear('start_date', now()->year)
                                    ->count(),
            'events_by_type' => Event::selectRaw('type, COUNT(*) as count')
                                ->groupBy('type')
                                ->get(),
            'total_participants' => Event::withCount('participants')
                                    ->get()
                                    ->sum('participants_count'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get calendar events for a specific month
     */
    public function calendar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $startDate = Carbon::create($request->year, $request->month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $events = Event::whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orderBy('start_date')
                        ->get(['id', 'title', 'start_date', 'end_date', 'type', 'status', 'location']);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Join an event
     */
    public function join(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:members,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::findOrFail($id);

        // Check if event is full
        if ($event->max_participants && $event->participants_count >= $event->max_participants) {
            return response()->json([
                'success' => false,
                'message' => 'Event is full'
            ], 400);
        }

        // Check if member is already participating
        if ($event->participants()->where('member_id', $request->member_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Member is already participating in this event'
            ], 400);
        }

        $event->participants()->attach($request->member_id, [
            'joined_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully joined the event'
        ]);
    }

    /**
     * Leave an event
     */
    public function leave(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:members,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::findOrFail($id);

        if (!$event->participants()->where('member_id', $request->member_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Member is not participating in this event'
            ], 400);
        }

        $event->participants()->detach($request->member_id);

        return response()->json([
            'success' => true,
            'message' => 'Successfully left the event'
        ]);
    }

    /**
     * Get event participants
     */
    public function participants(Request $request, int $id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $participants = $event->participants()
                            ->withPivot('joined_at')
                            ->orderBy('pivot_joined_at')
                            ->get();

        return response()->json([
            'success' => true,
            'data' => $participants
        ]);
    }
}
