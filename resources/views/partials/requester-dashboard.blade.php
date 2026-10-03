<div class="card">
    <div class="tab-header">
        <button class="tab-btn active" data-tab="request-form">Request Form</button>
        <button class="tab-btn" data-tab="my-requests">My Requests</button>
    </div>

    <div class="tab-content">
        <div id="request-form" class="tab-pane active">
            <form action="/document-requests" method="POST">
                @csrf
                <label for="requester_name">Requester Name</label>
                <input type="text" id="requester_name" name="requester_name" value="{{ auth()->user()->name }}" required readonly>

                <label for="requester_email">Requester Email</label>
                <input type="email" id="requester_email" name="requester_email" value="{{ auth()->user()->email }}" required readonly>

                <label for="item_name">Document Type / Item Name</label>
                <select id="item_name" name="item_name" required>
                    <option value="">-- Select --</option>
                    <option value="Certificate of Employment">Certificate of Employment</option>
                    <option value="Transcript of Records">Transcript of Records</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Good Moral Certificate">Good Moral Certificate</option>
                </select>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>

                <label for="purpose">Purpose</label>
                <textarea id="purpose" name="purpose" rows="3" required></textarea>

                <button type="submit" class="button">Submit Request</button>
            </form>
        </div>

        <div id="my-requests" class="tab-pane">
            @if ($requests->isEmpty())
                <p class="empty">You have not submitted any document requests yet.</p>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
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
                                    <td>{{ $request->item_name }}</td>
                                    <td>{{ $request->quantity }}</td>
                                    <td>{{ $request->purpose }}</td>
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
</div>

<style>
    .tab-header {
        display: flex;
        border-bottom: 1px solid var(--line);
        margin: -26px -28px 24px;
        padding: 0 28px;
    }
    .tab-btn {
        background: transparent;
        border: none;
        padding: 16px 24px;
        font-size: 14px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        position: relative;
        transition: color 0.15s ease;
    }
    .tab-btn:hover { color: var(--text); }
    .tab-btn.active {
        color: var(--accent);
    }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--accent);
        border-radius: 3px 3px 0 0;
    }
    .tab-content { position: relative; }
    .tab-pane {
        display: none;
        animation: fadeIn 0.15s ease;
    }
    .tab-pane.active { display: block; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-btn');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.dataset.tab;

                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                panes.forEach(p => p.classList.remove('active'));
                document.getElementById(targetTab).classList.add('active');
            });
        });
    });
</script>