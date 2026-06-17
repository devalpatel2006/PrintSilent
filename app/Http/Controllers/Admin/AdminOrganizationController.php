<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminOrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::orderBy('created_at', 'desc')->get();
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($validated['name']);
        
        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (Organization::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $organization = Organization::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'domain' => $validated['domain'],
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization "' . $organization->name . '" created successfully.');
    }

    public function show(Organization $organization)
    {
        return view('admin.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}
