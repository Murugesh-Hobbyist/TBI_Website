<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
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
            return redirect()->route('contact')->with('status', 'Thanks. Message received (database setup pending).');
        }

        return redirect()->route('contact')->with('status', 'Thanks. We will get back to you shortly.');
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
