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
        $name = $request->input('name');
        $email = $request->input('email');
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
            $existingGuest = Guest::where('email', $email)->first();
            if ($existingGuest) {
                $existingGuest->update([
                    'name' => $validatedData['name'],
                    'subject' => $validatedData['subject'],
                    'message' => $validatedData['message'],
                ]);
            } else {
                // Create a new user
                $guest = new Guest($validatedData);
                $guest->save();
            }


            return redirect('/#contact')->with('success', "Dear $name,
            we've received your message. Our team will review and get back to you shortly. Thank you!");

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return redirect('/#contact')->with('error', 'Oops! ' . implode(' ', $errors));

        }
    }
}
