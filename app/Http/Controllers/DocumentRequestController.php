<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DocumentRequestController extends Controller
{
    /**
     * LIST — GET /
     * Students see only their own records; administrators see every record.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', DocumentRequest::class);

        $user = $request->user();

        $requests = $user->isAdministrator()
            ? DocumentRequest::orderBy('created_at', 'desc')->get()
            : DocumentRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

        return view('welcome', compact('requests'));
    }

    /**
     * VIEW — GET /document-requests/{documentRequest}
     * Owner or administrator only; another student receives 403.
     */
    public function show(DocumentRequest $documentRequest)
    {
        Gate::authorize('view', $documentRequest);

        return view('document-requests.show', compact('documentRequest'));
    }

    /**
     * CREATE — POST /document-requests
     * Only validated fields are read from the input. user_id, requester
     * identity and the initial status are assigned from the signed-in account.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', DocumentRequest::class);

        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:150'],
            'quantity'  => ['required', 'integer', 'min:1'],
            'purpose'   => ['required', 'string', 'max:2000'],
        ]);

        $documentRequest = new DocumentRequest();
        $documentRequest->item_name = $validated['item_name'];
        $documentRequest->quantity = $validated['quantity'];
        $documentRequest->purpose = $validated['purpose'];
        $documentRequest->user_id = $request->user()->id;
        $documentRequest->requester_name = $request->user()->name;
        $documentRequest->requester_email = $request->user()->email;
        $documentRequest->status = 'pending';
        $documentRequest->save();

        return redirect()->route('dashboard')->with('success', 'Document request submitted successfully!');
    }

    /**
     * UPDATE STATUS — PATCH /document-requests/{documentRequest}
     * Administrator only. Only the status column may change.
     */
    public function updateStatus(Request $request, DocumentRequest $documentRequest)
    {
        Gate::authorize('updateStatus', $documentRequest);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $documentRequest->status = $validated['status'];
        $documentRequest->save();

        return redirect()->route('dashboard')->with('success', 'Request status updated successfully!');
    }
}
