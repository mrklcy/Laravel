<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry Notification</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1a5632, #2d8a4e); color: #fff; padding: 24px 30px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 600; }
        .header p { margin: 6px 0 0; font-size: 13px; opacity: 0.85; }
        .body { padding: 30px; }
        .label { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1f2937; margin-bottom: 18px; line-height: 1.5; }
        .message-box { background: #f9fafb; border-left: 4px solid #1a5632; padding: 16px 20px; border-radius: 0 6px 6px 0; margin: 8px 0 18px; }
        .message-box p { margin: 0; font-size: 14px; color: #374151; line-height: 1.6; white-space: pre-wrap; }
        .footer { background: #f9fafb; padding: 16px 30px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 12px; color: #9ca3af; }
        .badge { display: inline-block; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 12px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 New Inquiry Received</h1>
            <p>A new inquiry has been submitted through the CLSU ADSO website.</p>
        </div>

        <div class="body">
            @if($inquiry->office)
            <div class="label">Office</div>
            <div class="value">{{ $inquiry->office->name }} <span class="badge">{{ $inquiry->office->code }}</span></div>
            @endif

            <div class="label">From</div>
            <div class="value">{{ $inquiry->name }}</div>

            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $inquiry->email }}" style="color: #1a5632;">{{ $inquiry->email }}</a></div>

            @if($inquiry->phone)
            <div class="label">Phone</div>
            <div class="value">{{ $inquiry->phone }}</div>
            @endif

            @if($inquiry->inquiry_type)
            <div class="label">Type</div>
            <div class="value">{{ ucfirst($inquiry->inquiry_type) }}</div>
            @endif

            <div class="label">Subject</div>
            <div class="value" style="font-weight: 600;">{{ $inquiry->subject }}</div>

            <div class="label">Message</div>
            <div class="message-box">
                <p>{{ $inquiry->message }}</p>
            </div>

            <p style="font-size: 13px; color: #6b7280; margin-top: 24px;">
                You can view and respond to this inquiry from your <strong>admin panel</strong>.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Central Luzon State University — Administrative and Support Offices
        </div>
    </div>
</body>
</html>
