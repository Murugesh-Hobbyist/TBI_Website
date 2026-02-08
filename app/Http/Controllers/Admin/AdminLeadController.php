<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;

class AdminLeadController extends Controller
{
    public function index()
    {
        return view('admin.leads.index', [
            'leads' => Lead::query()->latest()->paginate(30),
        ]);
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', ['lead' => $lead]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('status', 'Lead deleted.');
    }
}

