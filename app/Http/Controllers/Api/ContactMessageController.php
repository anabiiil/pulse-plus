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
        // Detect language from request header or default to Arabic
        $locale = $request->header('Accept-Language', 'ar');
        if (str_contains($locale, 'en')) {
            $locale = 'en';
        } else {
            $locale = 'ar';
        }
        app()->setLocale($locale);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.validation_failed'),
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
                'message' => __('messages.contact_message_sent'),
                'data' => $contactMessage
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.contact_message_failed'),
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
                'message' => __('messages.contact_message_not_found')
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
                'message' => __('messages.contact_message_not_found')
            ], 404);
        }

        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => __('messages.contact_message_marked_as_read'),
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
                'message' => __('messages.contact_message_not_found')
            ], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => __('messages.contact_message_deleted')
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

    /**
     * Get contact information (Public)
     */
    public function getContactInfo(Request $request)
    {
        // Detect language from request header or default to Arabic
        $locale = $request->header('Accept-Language', 'ar');
        if (str_contains($locale, 'en')) {
            $locale = 'en';
        } else {
            $locale = 'ar';
        }

        // Get settings
        $phone = \App\Models\Setting::where('slug', 'phone')->first();
        $email = \App\Models\Setting::where('slug', 'email')->first();
        $address = \App\Models\Setting::where('slug', 'address')->first();

        return response()->json([
            'success' => true,
            'data' => [
                'phone' => $phone ? $phone->getTranslation('content', $locale) : '01555227756 / 01550111555',
                'email' => $email ? $email->getTranslation('content', $locale) : 'info@pulse-plus.com',
                'address' => $address ? $address->getTranslation('content', $locale) : ($locale === 'ar' ? 'القاهرة، جمهورية مصر العربية' : 'Cairo, Arab Republic of Egypt'),
            ]
        ]);
    }
}

