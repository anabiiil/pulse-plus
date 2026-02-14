<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * Store a new contact message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!',
                'data' => $contactMessage
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all contact messages (Admin)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status');

        $query = ContactMessage::query()->latest();

        if ($status && in_array($status, ['pending', 'read'])) {
            $query->where('status', $status);
        }

        $messages = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Get single contact message (Admin)
     */
    public function show($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Contact message not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }

    /**
     * Mark message as read (Admin)
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Contact message not found'
            ], 404);
        }

        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
            'data' => $message->fresh()
        ]);
    }

    /**
     * Delete contact message (Admin)
     */
    public function destroy($id)
    {
        $message = ContactMessage::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Contact message not found'
            ], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact message deleted successfully'
        ]);
    }

    /**
     * Get contact statistics (Admin)
     */
    public function statistics()
    {
        $total = ContactMessage::count();
        $pending = ContactMessage::where('status', 'pending')->count();
        $read = ContactMessage::where('status', 'read')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'pending' => $pending,
                'read' => $read,
            ]
        ]);
    }
}

