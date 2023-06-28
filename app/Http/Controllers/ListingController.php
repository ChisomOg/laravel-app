<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Rule;

class ListingController extends Controller
{
    // show all listing
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest() ->filter
            (request(['tag', 'search']))->paginate(4)
        ]);
    }

    //Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show create form
    public function create(){
        return view('listings.create');
    }

    //Store listing Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Listing::create($formFields);

        return redirect('/')->with('message', 'Job created successfully!');
    }

    //show edit form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Edit update
    public function update(Request $request, Listing $listing) {
        //make sure user is logged in
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Job updated successfully!');
    }

    // Delete job listing
    public function delete(Listing $listing){
        $listing->delete();
        return redirect('/')->with('message', 'Job successfully deleted!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        if($listing->logo && Storage::disk('public')->exists($listing->logo)) {
            Storage::disk('public')->delete($listing->logo);
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // manage listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
