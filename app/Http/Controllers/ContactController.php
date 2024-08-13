<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sortBy = $request->get('sort', 'name');
        $contacts = Contact::when($search, function($query) use ($search){
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        })->orderBy($sortBy)->paginate(10);

        return view('index', compact('contacts', 'search', 'sortBy'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');

    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }

}
