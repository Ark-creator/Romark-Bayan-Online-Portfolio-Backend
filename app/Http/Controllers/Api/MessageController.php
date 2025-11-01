<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Store a new message from the contact form.
     */
    public function store(Request $request)
    {
        // --- THIS IS YOUR SECURITY ---
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // If validation fails, return an error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // 422 is 'Unprocessable Entity'
        }

        // If validation passes, create and save the message
        $message = new Message();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        // Send a success response
        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message! I will get back to you soon.'
        ], 201); // 201 means 'Created'
    }
}
