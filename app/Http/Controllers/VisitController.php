<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Models\Patient;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'visit_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $visit = $patient->visits()->create([
            'doctor_id' => $request->doctor_id,
            'visit_date' => $request->visit_date,
            'diagnosis' => $request->diagnosis,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Visit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
