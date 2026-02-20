<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Office;
use App\Mail\NewInquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    public function create(Request $request)
    {
        $offices = Office::active()->get();
        $officeId = $request->get('office_id');
        return view('inquiries.create', compact('offices', 'officeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'office_id' => 'nullable|exists:offices,id',
            'inquiry_type' => 'nullable|string',
        ]);

        $inquiry = Inquiry::create($validated);

        // Send email notification to the office chief
        try {
            if ($inquiry->office_id) {
                $office = Office::find($inquiry->office_id);
                if ($office && $office->chief_email) {
                    $inquiry->load('office');
                    Mail::to($office->chief_email)->send(new NewInquiryNotification($inquiry));
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to send inquiry email notification: ' . $e->getMessage());
        }

        return redirect()->route('inquiries.create')
            ->with('success', 'Your inquiry has been submitted successfully. We will get back to you soon.');
    }
}
