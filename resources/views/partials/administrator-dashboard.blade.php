<section class="card">
    <div class="card-head">
        <div>
            <h2 class="card-title">Pending Review Queue</h2>
            <p class="card-subtitle">Approve or reject submissions waiting for a decision.</p>
        </div>
        <span class="count-badge tone-pending">{{ $requests->where('status', 'pending')->count() }} pending</span>
    </div>

    @if ($requests->where('status', 'pending')->isEmpty())
        <div class="empty-state">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <p>No pending requests to review.</p>
            <span>New submissions will appear here automatically.</span>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Document</th>
                        <th>Qty</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th class="th-action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $documentRequest)
                        @if ($documentRequest->status === 'pending')
                            <tr>
                                <td class="row-id">{{ $documentRequest->id }}</td>
                                <td>
                                    <div class="cell-primary">{{ $documentRequest->requester_name }}</div>
                                    <div class="cell-sub">{{ $documentRequest->requester_email }}</div>
                                </td>
                                <td class="cell-primary">{{ $documentRequest->item_name }}</td>
                                <td class="cell-num">{{ $documentRequest->quantity }}</td>
                                <td class="cell-muted cell-purpose">{{ $documentRequest->purpose }}</td>
                                <td><span class="status {{ $documentRequest->status }}">{{ $documentRequest->status }}</span></td>
                                <td class="cell-actions">
                                    <a href="{{ route('document-requests.show', $documentRequest) }}" class="button button-secondary action-btn">View</a>
                                    @can('updateStatus', $documentRequest)
                                        <form action="{{ route('document-requests.update-status', $documentRequest) }}" method="POST" class="status-form">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="status-select" aria-label="New status for request {{ $documentRequest->id }}">
                                                <option value="approved">Approve</option>
                                                <option value="rejected">Reject</option>
                                            </select>
                                            <button type="submit" class="button action-btn">Update</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

<section class="card">
    <div class="card-head">
        <div>
            <h2 class="card-title">Full Audit Trail</h2>
            <p class="card-subtitle">Every request in the system with creation and last-update timestamps.</p>
        </div>
        <span class="count-badge">{{ $requests->count() }} records</span>
    </div>

    @if ($requests->isEmpty())
        <div class="empty-state">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            <p>No document requests found in the system.</p>
            <span>Records will appear once students start submitting requests.</span>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Document</th>
                        <th>Qty</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $documentRequest)
                        <tr>
                            <td class="row-id">{{ $documentRequest->id }}</td>
                            <td>
                                <div class="cell-primary">{{ $documentRequest->requester_name }}</div>
                                <div class="cell-sub">{{ $documentRequest->requester_email }}</div>
                            </td>
                            <td class="cell-primary">{{ $documentRequest->item_name }}</td>
                            <td class="cell-num">{{ $documentRequest->quantity }}</td>
                            <td class="cell-muted cell-purpose">{{ $documentRequest->purpose }}</td>
                            <td><span class="status {{ $documentRequest->status }}">{{ $documentRequest->status }}</span></td>
                            <td class="timestamp-col">{{ $documentRequest->created_at->format('M d, Y H:i:s') }}</td>
                            <td class="timestamp-col">{{ $documentRequest->updated_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
