<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceOrder;
use App\Models\Asset;
use Illuminate\Http\Request;

class MaintenanceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenanceOrders = MaintenanceOrder::with('asset')->paginate(10);
        return view('admin.patrimony.maintenance_orders.index', compact('maintenanceOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::all();
        return view('admin.patrimony.maintenance_orders.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        MaintenanceOrder::create($request->all());

        return redirect()->route('patrimony.maintenance_orders.index')->with('success', 'Maintenance order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceOrder $maintenanceOrder)
    {
        return view('admin.patrimony.maintenance_orders.show', compact('maintenanceOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceOrder $maintenanceOrder)
    {
        $assets = Asset::all();
        return view('admin.patrimony.maintenance_orders.edit', compact('maintenanceOrder', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceOrder $maintenanceOrder)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $maintenanceOrder->update($request->all());

        return redirect()->route('patrimony.maintenance_orders.index')->with('success', 'Maintenance order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceOrder $maintenanceOrder)
    {
        $maintenanceOrder->delete();

        return redirect()->route('patrimony.maintenance_orders.index')->with('success', 'Maintenance order deleted successfully.');
    }
}
