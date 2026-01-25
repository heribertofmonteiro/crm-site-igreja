<?php

namespace App\Http\Controllers;

use App\Models\SystemAccessLog;
use Illuminate\Http\Request;

class SystemAccessLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:system_access.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SystemAccessLog::with('user');

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('accessed_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('accessed_at', '<=', $request->date_to . ' 23:59:59');
        }

        $logs = $query->orderBy('accessed_at', 'desc')->paginate(20);

        $users = \App\Models\User::all();

        return view('admin.it.access.index', compact('logs', 'users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemAccessLog $log)
    {
        return view('admin.it.access.show', compact('log'));
    }
}