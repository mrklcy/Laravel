<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Response</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1a5632, #2d8a4e); color: #fff; padding: 24px 30px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 600; }
        .header p { margin: 6px 0 0; font-size: 13px; opacity: 0.85; }
        .body { padding: 30px; }
        .greeting { font-size: 16px; color: #1f2937; margin-bottom: 16px; }
        .label { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1f2937; margin-bottom: 18px; line-height: 1.5; }
        .response-box { background: #ecfdf5; border-left: 4px solid #1a5632; padding: 16px 20px; border-radius: 0 6px 6px 0; margin: 8px 0 18px; }
        .response-box p { margin: 0; font-size: 14px; color: #374151; line-height: 1.6; white-space: pre-wrap; }
        .original-box { background: #f9fafb; border-left: 4px solid #d1d5db; padding: 14px 18px; border-radius: 0 6px 6px 0; margin: 8px 0 18px; }
        .original-box p { margin: 0; font-size: 13px; color: #6b7280; line-height: 1.5; white-space: pre-wrap; }
        .footer { background: #f9fafb; padding: 16px 30px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 12px; color: #9ca3af; }
        .badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 12px; text-transform: uppercase; }
        .badge-resolved { background: #dcfce7; color: #166534; }
        .badge-in-progress { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 Response to Your Inquiry</h1>
            @if($inquiry->office)
            <p>From: {{ $inquiry->office->name }} ({{ $inquiry->office->code }})</p>
            @else
            <p>From: CLSU Administrative and Support Offices</p>
            @endif
        </div>

        <div class="body">
            <div class="greeting">
                Dear <strong>{{ $inquiry->name }}</strong>,
            </div>

            <p style="font-size: 14px; color: #4b5563; margin-bottom: 20px;">
                Thank you for reaching out. We have reviewed your inquiry and here is our response:
            </p>

            <div class="label">Our Response</div>
            <div class="response-box">
                <p>{{ $inquiry->response }}</p>
            </div>

            <div class="label">Status</div>
            <div class="value">
                @if($inquiry->status === 'resolved')
                    <span class="badge badge-resolved">Resolved</span>
                @elseif($inquiry->status === 'in_progress')
                    <span class="badge badge-in-progress">In Progress</span>
                @else
                    <span class="badge" style="background: #e5e7eb; color: #374151;">{{ ucfirst($inquiry->status) }}</span>
                @endif
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <div class="label">Your Original Inquiry</div>
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 6px;"><strong>Subject:</strong> {{ $inquiry->subject }}</div>
            <div class="original-box">
                <p>{{ $inquiry->message }}</p>
            </div>

            <p style="font-size: 13px; color: #6b7280; margin-top: 24px;">
                If you have further questions, you may reply to this email or submit a new inquiry through our website.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Central Luzon State University — Administrative and Support Offices
        </div>
    </div>
</body>
</html>
