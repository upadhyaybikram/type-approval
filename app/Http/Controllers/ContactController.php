<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
      //  dd($request->input());
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('guests', 'email')
                ],
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $guest = new Guest($validatedData);
            $guest->save();

            return redirect('/#contact')->with('success', 'Thank you! Your message has been submitted successfully.
            One of our agent will contact you soon. ');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
           // return response()->json(['error' => $errors], 422);
            return redirect('/#contact')->with('error', 'Oops! This user has already been registered');

        }
    }
}
