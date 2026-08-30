<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function home()
    {
        // Prefer rendering the public site even if DB is not configured on the server.
        $featuredProducts = collect(config('twinbot.products', []))->take(6)->values();

        return view('site.home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }

    public function features()
    {
        return view('site.features');
    }

    public function solutions()
    {
        return view('site.solutions');
    }

    public function pricing()
    {
        return view('site.pricing');
    }

    public function about()
    {
        return view('site.about');
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function quote()
    {
        return redirect()->route('contact');
    }

    public function forum()
    {
        return view('site.forum');
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['nullable', 'string', 'max:5000'],
        ]);

        $data['type'] = 'contact';
        $data['meta'] = [
            'ip' => $request->ip(),
            'ua' => Str::limit((string) $request->userAgent(), 512, '...'),
        ];

        try {
            Lead::create($data);
        } catch (\Throwable $e) {
            Log::warning('Contact lead could not be saved.', ['exception' => $e]);
        }

        $recipient = (string) config('twinbot.contact.email_primary');
        $replyTo = $data['email'] ?? null;
        $mailer = (string) config('mail.default');

        if ($recipient === '') {
            return redirect()->route('contact')->with('status', 'Email was not sent: the support recipient is not configured.');
        }

        if (in_array($mailer, ['array', 'log'], true)) {
            return redirect()->route('contact')->with('status', 'Email was not sent: the live server is still using '.$mailer.' mail instead of SMTP.');
        }

        try {

            $message = "New website contact request\n\n"
                ."Name: {$data['name']}\n"
                ."Company: ".($data['company'] ?: 'Not provided')."\n"
                ."Email: ".($data['email'] ?: 'Not provided')."\n"
                ."Subject: {$data['subject']}\n\n"
                ."Message:\n".($data['message'] ?: 'Not provided');

            $sentMessage = Mail::raw($message, function ($mail) use ($recipient, $replyTo, $data) {
                $mail->to($recipient)->subject('[TwinBot website] '.$data['subject']);

                if ($replyTo) {
                    $mail->replyTo($replyTo, $data['name']);
                }
            });

            $messageId = $sentMessage?->getMessageId();
            Log::info('Contact notification accepted by mail transport.', [
                'recipient' => $recipient,
                'mailer' => $mailer,
                'message_id' => $messageId,
            ]);
        } catch (\Throwable $e) {
            Log::error('Contact notification email could not be sent.', ['exception' => $e]);

            $error = strtolower($e->getMessage());
            $status = str_contains($error, 'authentication') || str_contains($error, 'username') || str_contains($error, 'password')
                ? 'Email was not sent: Hostinger rejected the mailbox username or password.'
                : (str_contains($error, 'connection') || str_contains($error, 'stream_socket')
                    ? 'Email was not sent: the SMTP server could not be reached. Check host, port, and encryption.'
                    : 'Email was not sent: the SMTP server rejected the message. Please verify the Hostinger mail settings.');

            return redirect()->route('contact')->with('status', $status);
        }

        return redirect()->route('contact')->with('status', 'Email accepted by TwinBot’s mail server and sent to support.'.($messageId ? ' Reference: '.$messageId : ''));
    }

    public function submitQuote(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:5000'],
        ]);

        $data['type'] = 'quote';
        $data['meta'] = [
            'ip' => $request->ip(),
            'ua' => Str::limit((string) $request->userAgent(), 512, '...'),
        ];

        try {
            Lead::create($data);
        } catch (\Throwable $e) {
            return redirect()->route('contact')->with('status', 'Quote request received (database setup pending).');
        }

        return redirect()->route('contact')->with('status', 'Quote request received. We will contact you.');
    }
}
