<section class="card">
    <h2 class="card-title">All Document Request Records (Audit Trail)</h2>
    @if ($requests->isEmpty())
        <p class="empty">No document requests found in the system.</p>
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
                        <th>Created At</th>
                        <th>Updated At</th>
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
                            <td class="timestamp-col">{{ $request->created_at->format('M d, Y H:i:s') }}</td>
                            <td class="timestamp-col">{{ $request->updated_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>