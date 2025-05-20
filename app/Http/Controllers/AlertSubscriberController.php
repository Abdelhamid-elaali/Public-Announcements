<?php

namespace App\Http\Controllers;

use App\Models\AlertSubscriber;
use Illuminate\Http\Request;

class AlertSubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:alert_subscribers,email',
            'phone_number' => 'nullable|string|max:20',
            'sms_enabled' => 'boolean',
            'email_enabled' => 'boolean'
        ]);

        AlertSubscriber::create($validated);

        return back()->with('success', 'Successfully subscribed to alerts.');
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:alert_subscribers,email'
        ]);

        AlertSubscriber::where('email', $validated['email'])->delete();

        return back()->with('success', 'Successfully unsubscribed from alerts.');
    }

    public function adminIndex()
    {
        $subscribers = AlertSubscriber::paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function sendAlert(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // TODO: Implement notification sending logic using Brevo for email and Twilio for SMS
        // This should be handled by a job queue for large subscriber lists

        return back()->with('success', 'Alert sent successfully.');
    }
}
