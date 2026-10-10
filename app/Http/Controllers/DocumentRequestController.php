<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    // Display dashboard based on user role
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            return $this->studentDashboard();
        } elseif ($user->isAdministrator()) {
            return $this->administratorDashboard();
        }

        abort(403);
    }

    // Student: Submit document requests and view own records (user id ownership)
    public function studentDashboard()
    {
        $requests = DocumentRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('requests'));
    }

    // Administrator: View, review, and audit all records
    public function administratorDashboard()
    {
        $requests = DocumentRequest::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('requests'));
    }

    // Store new request (Student only)
    public function store(Request $request)
    {
        $this->authorizeStudent();

        $validated = $request->validate([
            'requester_name'  => 'required|string|max:100',
            'requester_email' => 'required|email|max:255',
            'item_name'       => 'required|string|max:150',
            'quantity'        => 'required|integer|min:1',
            'purpose'         => 'required|string',
        ]);

        DocumentRequest::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect('/')->with('success', 'Document request submitted successfully!');
    }

    // Update request status (Administrator only)
    public function update(Request $request, DocumentRequest $documentRequest)
    {
        $this->authorizeAdministrator();

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $documentRequest->update($validated);

        return redirect('/')->with('success', 'Request status updated successfully!');
    }

    private function authorizeStudent()
    {
        if (!Auth::user()->canSubmitRequest()) {
            abort(403, 'Only students can submit document requests.');
        }
    }

    private function authorizeAdministrator()
    {
        if (!Auth::user()->canReviewRequests()) {
            abort(403, 'Only administrators can update request status.');
        }
    }
}