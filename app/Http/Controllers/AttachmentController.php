<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\Visit;

class AttachmentController extends Controller
{
    public function storeAttachment(Request $request, Visit $visit)
{
    $request->validate([
        'file' => 'required|file',
        'type' => 'nullable|string',
    ]);

    $path = $request->file('file')->store('attachments');

    $visit->attachments()->create([
        'file_path' => $path,
        'type' => $request->type,
    ]);

    return back()->with('success', 'File uploaded');
}
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        //
    }
}
