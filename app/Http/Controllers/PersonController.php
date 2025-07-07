<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\LogPersonActionJob;
use App\Http\Requests\StorePersonRequest;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::paginate(4);
        return view('pages.people.index', compact('people'));
    }

    public function create()
    {
        return view('pages.people.create');
    }

    public function store(StorePersonRequest $request)
    {
        $validated = $request->validated();
        $person = Person::create($validated);
        LogPersonActionJob::dispatch('created', $person->toArray());
        return redirect()->route('people.index')->with('success', 'Person created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return view('pages.people.edit', compact('person'));
    }

    public function update(StorePersonRequest $request, $id)
    {
        $person = Person::findOrFail($id);
        $validated = $request->validated();
        $person->update($validated);
        LogPersonActionJob::dispatch('update', $person->toArray());
        return redirect()->route('people.index')->with('success', 'Person updated successfully.');
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        LogPersonActionJob::dispatch('destroy', $person->toArray());
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Person deleted successfully.');
    }

}
