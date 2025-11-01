<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// 1. Import the Mail facade and your new Mailable
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageReceived;

class MessageController extends Controller
{
    /**
     * Store a new message from the contact form.
     */
    public function store(Request $request)
    {
        // --- THIS IS YOUR SECURITY ---
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

        // --- UPDATED PART ---
        // Create and save the message
        $message = Message::create($validator->validated());

        // --- 2. SEND THE EMAIL ---
        // After saving, send the email to your personal address
      try {
    Mail::to('romark7bayan@gmail.com')->send(new NewMessageReceived($message));
} catch (\Exception $e) {
    // Temporarily return the exact error message
    return response()->json([
        'success' => false,
        'error_message' => $e->getMessage()
    ], 500);
}

        return response()->json([
            'success' => true
        ]);
    }
}