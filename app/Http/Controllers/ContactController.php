<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
       // return view('comment');
        return view('welcome');
    }


    public function store(Request $request)
    {
      //  dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('guests', 'email'), // Check uniqueness in the "guests" table
            ],
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
     

        try {
            $guest = new Guest($validatedData);
            $guest->save();

        } catch(\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Email is not unique.'], 422);

        }
        
        return redirect('/');

    }
}
