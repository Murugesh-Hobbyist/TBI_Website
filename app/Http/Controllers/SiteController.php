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

        try {
            $recipient = (string) config('twinbot.contact.email_primary');
            $replyTo = $data['email'] ?? null;
            $message = "New website contact request\n\n"
                ."Name: {$data['name']}\n"
                ."Company: ".($data['company'] ?: 'Not provided')."\n"
                ."Email: ".($data['email'] ?: 'Not provided')."\n"
                ."Subject: {$data['subject']}\n\n"
                ."Message:\n".($data['message'] ?: 'Not provided');

            Mail::raw($message, function ($mail) use ($recipient, $replyTo, $data) {
                $mail->to($recipient)->subject('[TwinBot website] '.$data['subject']);

                if ($replyTo) {
                    $mail->replyTo($replyTo, $data['name']);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Contact notification email could not be sent.', ['exception' => $e]);

            return redirect()->route('contact')->with('status', 'Your request was received, but email delivery needs attention. Please email support directly.');
        }

        return redirect()->route('contact')->with('status', 'Thanks. Your request was sent to TwinBot support.');
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
