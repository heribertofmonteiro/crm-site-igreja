<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of members
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,visitor',
            'group_id' => 'nullable|integer|exists:groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Member::with(['family', 'groups']);

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->group_id) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->where('groups.id', $request->group_id);
            });
        }

        $members = $query->orderBy('name')
                        ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    /**
     * Display the specified member
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $member = Member::with(['family', 'groups', 'contributions'])
                      ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

    /**
     * Store a newly created member
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'baptism_date' => 'nullable|date|before:today',
            'status' => 'nullable|in:active,inactive,visitor',
            'family_id' => 'nullable|integer|exists:families,id',
            'groups' => 'nullable|array',
            'groups.*' => 'integer|exists:groups,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except(['photo', 'groups']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('members/photos', 'public');
            $data['photo'] = $photoPath;
        }

        $member = Member::create($data);

        // Attach groups
        if ($request->groups) {
            $member->groups()->attach($request->groups);
        }

        return response()->json([
            'success' => true,
            'message' => 'Member created successfully',
            'data' => $member->load(['family', 'groups'])
        ], 201);
    }

    /**
     * Update the specified member
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:members,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'baptism_date' => 'nullable|date|before:today',
            'status' => 'nullable|in:active,inactive,visitor',
            'family_id' => 'nullable|integer|exists:families,id',
            'groups' => 'nullable|array',
            'groups.*' => 'integer|exists:groups,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except(['photo', 'groups']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('members/photos', 'public');
            $data['photo'] = $photoPath;
        }

        $member->update($data);

        // Sync groups
        if ($request->groups) {
            $member->groups()->sync($request->groups);
        }

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully',
            'data' => $member->load(['family', 'groups'])
        ]);
    }

    /**
     * Remove the specified member
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $member = Member::findOrFail($id);

        // Delete photo if exists
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member deleted successfully'
        ]);
    }

    /**
     * Get member statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $stats = [
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'inactive_members' => Member::where('status', 'inactive')->count(),
            'visitors' => Member::where('status', 'visitor')->count(),
            'new_members_this_month' => Member::whereMonth('created_at', now()->month)
                                           ->whereYear('created_at', now()->year)
                                           ->count(),
            'baptized_members' => Member::whereNotNull('baptism_date')->count(),
            'members_by_group' => Member::withCount('groups')
                                    ->get()
                                    ->map(function ($member) {
                                        return [
                                            'member_id' => $member->id,
                                            'name' => $member->name,
                                            'groups_count' => $member->groups_count,
                                        ];
                                    })
                                    ->sortByDesc('groups_count')
                                    ->take(10),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Search members
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2|max:255',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $members = Member::where('name', 'like', '%' . $request->query . '%')
                        ->orWhere('email', 'like', '%' . $request->query . '%')
                        ->orWhere('phone', 'like', '%' . $request->query . '%')
                        ->limit($request->input('limit', 20))
                        ->get(['id', 'name', 'email', 'phone', 'status']);

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    /**
     * Get member contributions
     */
    public function contributions(Request $request, int $id): JsonResponse
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'nullable|in:tithe,offering,special',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = $member->contributions();

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $contributions = $query->orderByDesc('date')->get();

        $total = $contributions->sum('amount');

        return response()->json([
            'success' => true,
            'data' => [
                'contributions' => $contributions,
                'total_amount' => $total,
                'member' => $member
            ]
        ]);
    }
}
