<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::latest()->get();

        return view('document-requests.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'requestor_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'purpose' => 'required|string',
        ]);

        $validated['status'] = 'Pending';

        DocumentRequest::create($validated);

        return redirect('/')->with('success', 'Document request submitted successfully.');
    }
}
