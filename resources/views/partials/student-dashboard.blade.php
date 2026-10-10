<section class="card">
    <div class="card-head">
        <div>
            <h2 class="card-title">Document Request Center</h2>
            <p class="card-subtitle">Complete the form below to file a new request with the registrar.</p>
        </div>
    </div>

    <div class="tab-header">
        <button class="tab-btn active" data-tab="request-form" type="button">Request Form</button>
        <button class="tab-btn" data-tab="my-requests" type="button">My Requests <span class="tab-count">{{ $requests->count() }}</span></button>
    </div>

    <div class="tab-content">
        <div id="request-form" class="tab-pane active">
            <form action="/document-requests" method="POST" class="request-form">
                @csrf

                <div class="form-section-label">Requester details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="requester_name">Student Name</label>
                        <input type="text" id="requester_name" name="requester_name" value="{{ auth()->user()->name }}" required readonly>
                        <span class="field-hint">Taken automatically from your account.</span>
                    </div>
                    <div class="form-group">
                        <label for="requester_email">Student Email</label>
                        <input type="email" id="requester_email" name="requester_email" value="{{ auth()->user()->email }}" required readonly>
                        <span class="field-hint">Taken automatically from your account.</span>
                    </div>
                </div>

                <div class="form-section-label">Request information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item_name">Document Type / Item Name</label>
                        <select id="item_name" name="item_name" required>
                            <option value="">-- Select --</option>
                            <option value="Certificate of Employment">Certificate of Employment</option>
                            <option value="Transcript of Records">Transcript of Records</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Good Moral Certificate">Good Moral Certificate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <textarea id="purpose" name="purpose" rows="3" maxlength="2000" required placeholder="State the reason for this request..."></textarea>
                    <span class="field-hint">Maximum of 2,000 characters.</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button">Submit Request</button>
                </div>
            </form>
        </div>

        <div id="my-requests" class="tab-pane">
            <div class="table-head">
                <h3 class="table-title">Submission History</h3>
            </div>

            @if ($requests->isEmpty())
                <div class="empty-state">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <p>You have not submitted any document requests yet.</p>
                    <span>Switch to the Request Form tab to file your first request.</span>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document</th>
                                <th>Qty</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td class="row-id">{{ $request->id }}</td>
                                    <td class="cell-primary">{{ $request->item_name }}</td>
                                    <td class="cell-num">{{ $request->quantity }}</td>
                                    <td class="cell-muted cell-purpose">{{ $request->purpose }}</td>
                                    <td><span class="status {{ $request->status }}">{{ $request->status }}</span></td>
                                    <td class="timestamp-col">{{ $request->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
