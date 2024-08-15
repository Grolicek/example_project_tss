<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Person::query();

        $search = $request->input('search');

        if ($search) {
            if (is_numeric($search)) {
                $query->where('age', $search);
            } else {
                $genderEnum = GenderEnum::getEnum(mb_strtolower($search));
                if ($genderEnum !== null) {
                    $query->where('gender', $genderEnum->value);
                } else {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                }
            }
        }

        $people = $query->get();

        return PersonResource::collection($people);
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
    public function show(string $id)
    {
        $person = Person::findOrFail($id);

        return PersonResource::make($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:256',
            'age' => 'required|integer|min:0',
            'gender' => 'required|integer|in:1,2',
        ]);

        $person = Person::findOrFail($id);

        $person->update($validatedData);

        return PersonResource::make($person);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::find($id)->delete();

        if (!$person) {
            return response()->json([
                'message' => 'Person not found.',
            ])->setStatusCode(403);
        }

        return response()->json([
            'message' => 'Success.',
        ])->setStatusCode(200);
    }
}
