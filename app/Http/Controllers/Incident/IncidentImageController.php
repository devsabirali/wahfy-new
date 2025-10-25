<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use App\Models\IncidentImage;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentImageController extends Controller
{
    /**
     * Display a listing of the images.
     * If incident_id is provided, filter by incident.
     */
    public function index(Request $request)
    {
        $query = IncidentImage::with('incident');

        // Optional filter by incident_id
        if ($request->has('incident_id')) {
            $query->where('incident_id', $request->incident_id);
        }

        // Paginate images
        $images = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.incidents.images.index', compact('images'))
            ->with('incident_id', $request->incident_id ?? null);
    }

    /**
     * Show the form for creating a new image.
     */
    public function create(Request $request)
    {
        $incidentId = $request->incident_id ?? null;
        $incidents  = Incident::all(); // Fetch all incidents for dropdown
        return view('admin.incidents.images.create', compact('incidentId', 'incidents'));
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'image_path'  => 'required|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('incident-images', 'public');
            $validated['image_path'] = $path;
        }

        IncidentImage::create($validated);

        return redirect()->route('admin.incident-images.index', ['incident_id' => $validated['incident_id']])
            ->with('success', 'Incident image created successfully.');
    }

    /**
     * Display the specified image.
     */
    public function show(IncidentImage $incidentImage)
    {
        return view('admin.incidents.images.show', compact('incidentImage'));
    }

    /**
     * Show the form for editing the specified image.
     */
    public function edit(IncidentImage $incidentImage)
    {
        $incidentId = $incidentImage->incident_id;
        $incidents  = Incident::all();
        return view('admin.incidents.images.edit', compact('incidentImage', 'incidentId', 'incidents'));
    }

    /**
     * Update the specified image in storage.
     */
    public function update(Request $request, IncidentImage $incidentImage)
    {
        $validated = $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'image_path'  => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('incident-images', 'public');
            $validated['image_path'] = $path;
        }

        $incidentImage->update($validated);

        return redirect()->route('admin.incident-images.index', ['incident_id' => $validated['incident_id']])
            ->with('success', 'Incident image updated successfully.');
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy(IncidentImage $incidentImage)
    {
        $incidentId = $incidentImage->incident_id;
        $incidentImage->delete();

        return redirect()->route('admin.incident-images.index', ['incident_id' => $incidentId])
            ->with('success', 'Incident image deleted successfully.');
    }
}
