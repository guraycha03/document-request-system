<section class="card">
    <h2 class="card-title">Pending Requests</h2>
    @if ($requests->where('status', 'pending')->isEmpty())
        <p class="empty">No pending requests to review.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Requester</th>
                        <th>Email</th>
                        <th>Document</th>
                        <th>Qty</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        @if ($request->status === 'pending')
                            <tr>
                                <td class="row-id">{{ $request->id }}</td>
                                <td>{{ $request->requester_name }}</td>
                                <td>{{ $request->requester_email }}</td>
                                <td>{{ $request->item_name }}</td>
                                <td>{{ $request->quantity }}</td>
                                <td>{{ $request->purpose }}</td>
                                <td><span class="status {{ $request->status }}">{{ $request->status }}</span></td>
                                <td>
                                    <form action="/document-requests/{{ $request->id }}" method="POST" class="status-form">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="status-select">
                                            <option value="approved" {{ $request->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        <button type="submit" class="button action-btn">Update</button>
                                    </form>
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
    <h2 class="card-title">All Requests</h2>
    @if ($requests->isEmpty())
        <p class="empty">No document requests found.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Requester</th>
                        <th>Email</th>
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
                            <td>{{ $request->requester_name }}</td>
                            <td>{{ $request->requester_email }}</td>
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
</section>