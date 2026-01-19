<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333333;
            margin: 0;
        }
        .content {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            letter-spacing: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #888888;
            font-size: 14px;
            margin-top: 30px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 12px;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $appName }}</h1>
        </div>

        <div class="content">
            <p>Your verification code is:</p>
            <div class="otp-code">{{ $code }}</div>
            <p>This code will expire in <strong>{{ $expiresIn }} minutes</strong>.</p>
        </div>

        <div class="warning">
            ⚠️ Never share this code with anyone. {{ $appName }} will never ask for your verification code.
        </div>

        <div class="footer">
            <p>If you didn't request this code, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $code,
        public array $data = []
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'] ?? 'Your Verification Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'code' => $this->code,
                'expiresIn' => $this->data['expires_in'] ?? 5,
                'appName' => config('app.name'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

