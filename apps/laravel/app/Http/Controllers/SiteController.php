<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Product;
use App\Models\Project;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function home()
    {
        return view('site.home', [
            'featuredProducts' => Product::query()->where('is_published', true)->latest()->limit(3)->get(),
            'featuredProjects' => Project::query()->where('is_published', true)->latest('published_at')->limit(3)->get(),
            'featuredVideos' => Video::query()->where('is_published', true)->latest('published_at')->limit(3)->get(),
        ]);
    }

    public function solutions()
    {
        return view('site.solutions');
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
        return view('site.quote');
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

        Lead::create($data);

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

        Lead::create($data);

        return redirect()->route('quote')->with('status', 'Quote request received. We will contact you.');
    }
}

