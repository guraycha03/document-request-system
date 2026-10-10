@extends('layouts.app')

@section('title', 'Request #' . $documentRequest->id . ' - Document Request System')
@section('body-class', 'dashboard-page')

@section('content')
    @include('partials.global-header', ['headerSubtitle' => 'Request Details'])

    <main class="container">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to dashboard
        </a>

        <section class="card">
            <div class="card-head detail-head">
                <div>
                    <p class="detail-eyebrow">Request #{{ $documentRequest->id }}</p>
                    <h2 class="card-title">{{ $documentRequest->item_name }}</h2>
                    <p class="card-subtitle">Submitted on {{ $documentRequest->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <span class="status {{ $documentRequest->status }}">{{ $documentRequest->status }}</span>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Requester</span>
                    <span class="detail-value">{{ $documentRequest->requester_name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $documentRequest->requester_email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value">{{ $documentRequest->quantity }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Last updated</span>
                    <span class="detail-value">{{ $documentRequest->updated_at->format('M d, Y H:i:s') }}</span>
                </div>
            </div>

            <div class="detail-purpose">
                <span class="detail-label">Purpose</span>
                <p>{{ $documentRequest->purpose }}</p>
            </div>

            @can('updateStatus', $documentRequest)
                <div class="detail-admin">
                    <div class="detail-admin-head">
                        <span class="detail-label">Administrator action</span>
                        <span class="field-hint">Only the status column is updated.</span>
                    </div>

                    <form action="{{ route('document-requests.update-status', $documentRequest) }}" method="POST" class="status-form detail-form">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="status-select" aria-label="New status for request {{ $documentRequest->id }}">
                            <option value="pending" @selected($documentRequest->status === 'pending')>Pending</option>
                            <option value="approved" @selected($documentRequest->status === 'approved')>Approved</option>
                            <option value="rejected" @selected($documentRequest->status === 'rejected')>Rejected</option>
                        </select>
                        <button type="submit" class="button action-btn">Update Status</button>
                    </form>
                </div>
            @endcan
        </section>
    </main>
@endsection
