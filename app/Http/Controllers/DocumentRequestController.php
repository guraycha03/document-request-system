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

        if ($user->isRequester()) {
            return $this->requesterDashboard();
        } elseif ($user->isStaffReviewer()) {
            return $this->staffReviewerDashboard();
        } elseif ($user->isRecordKeeper()) {
            return $this->recordKeeperDashboard();
        }

        abort(403);
    }

    // Requester: Submit document requests
    public function requesterDashboard()
    {
        $requests = DocumentRequest::where('requester_email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('requests'));
    }

    // Staff Reviewer: View and process pending requests
    public function staffReviewerDashboard()
    {
        $requests = DocumentRequest::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('requests'));
    }

    // Record Keeper: View all records with timestamps
    public function recordKeeperDashboard()
    {
        $requests = DocumentRequest::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('requests'));
    }

    // Store new request (Requester only)
    public function store(Request $request)
    {
        $this->authorizeRequester();

        $validated = $request->validate([
            'requester_name'  => 'required|string|max:100',
            'requester_email' => 'required|email|max:255',
            'item_name'       => 'required|string|max:150',
            'quantity'        => 'required|integer|min:1',
            'purpose'         => 'required|string',
        ]);

        DocumentRequest::create($validated);

        return redirect('/')->with('success', 'Document request submitted successfully!');
    }

    // Update request status (Staff Reviewer only)
    public function update(Request $request, DocumentRequest $documentRequest)
    {
        $this->authorizeStaffReviewer();

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $documentRequest->update($validated);

        return redirect('/')->with('success', 'Request status updated successfully!');
    }

    private function authorizeRequester()
    {
        if (!Auth::user()->canSubmitRequest()) {
            abort(403, 'Only requesters can submit document requests.');
        }
    }

    private function authorizeStaffReviewer()
    {
        if (!Auth::user()->canReviewRequests()) {
            abort(403, 'Only staff reviewers can update request status.');
        }
    }
}