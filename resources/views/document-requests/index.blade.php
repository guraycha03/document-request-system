<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document Request System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #eef1f4;
            --surface: #ffffff;
            --text: #2b323a;
            --muted: #68727d;
            --line: #dfe3e9;
            --accent: #2f6b57;
            --accent-hover: #265949;
            --accent-ring: rgba(47, 107, 87, 0.16);
            --radius: 14px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 40px 24px;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            letter-spacing: 0.2px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container { max-width: 840px; margin: 0 auto; }

        .app-header { margin-bottom: 24px; }
        .brand { display: flex; align-items: center; gap: 14px; }
        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--accent);
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(47, 107, 87, 0.25);
        }
        .brand h1 { font-size: 20px; font-weight: 700; letter-spacing: 0.3px; margin: 0; }
        .subtitle { color: var(--muted); font-size: 14px; margin: 2px 0 0; }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 26px 28px;
            margin-bottom: 22px;
            box-shadow: 0 1px 2px rgba(20, 30, 40, 0.04), 0 8px 24px rgba(20, 30, 40, 0.05);
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin: 0 0 20px;
            color: var(--text);
            text-transform: uppercase;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d3d9e0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: #fbfcfd;
            margin-bottom: 18px;
            letter-spacing: 0.2px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
            background: #ffffff;
            box-shadow: 0 0 0 4px var(--accent-ring);
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            padding-right: 42px;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2368727d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
        }

        textarea { resize: vertical; min-height: 84px; }

        .button {
            background: var(--accent);
            color: #ffffff;
            border: 0;
            padding: 12px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.05s ease;
        }
        .button:hover { background: var(--accent-hover); }
        .button:active { transform: translateY(1px); }

        .success {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #e8f3ee;
            color: #2c5a47;
            border: 1px solid #cfe3d8;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 22px;
        }
        .success svg { flex-shrink: 0; }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th {
            background: #f4f6f8;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--muted);
            text-align: left;
            padding: 12px 14px;
            white-space: nowrap;
        }
        th:first-child { border-top-left-radius: 8px; }
        th:last-child { border-top-right-radius: 8px; }
        td { padding: 14px; border-top: 1px solid var(--line); vertical-align: top; }
        td.row-id { color: var(--muted); white-space: nowrap; }
        tbody tr:hover { background: #fafbfc; }
        tbody tr:last-child td { border-bottom: 1px solid var(--line); }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            background: #fbf0dc;
            color: #8a6d2b;
            border: 1px solid #f2e0b8;
            white-space: nowrap;
        }
        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d9a13b;
        }

        .empty {
            color: var(--muted);
            font-size: 14px;
            text-align: center;
            padding: 28px 0;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="app-header">
            <div class="brand">
                <div class="brand-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <div>
                    <h1>Document Request System</h1>
                    <p class="subtitle">Submit a document request and view all submitted requests.</p>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <section class="card">
            <h2 class="card-title">New Request</h2>
            <form action="/document-requests" method="POST">
                @csrf
                <label for="requestor_name">Requestor Name</label>
                <input type="text" id="requestor_name" name="requestor_name" value="{{ old('requestor_name') }}" required>

                <label for="document_type">Document Type</label>
                <select id="document_type" name="document_type" required>
                    <option value="">-- Select --</option>
                    <option value="Certificate of Employment">Certificate of Employment</option>
                    <option value="Transcript of Records">Transcript of Records</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Good Moral Certificate">Good Moral Certificate</option>
                </select>

                <label for="purpose">Purpose</label>
                <textarea id="purpose" name="purpose" rows="3" required>{{ old('purpose') }}</textarea>

                <button type="submit" class="button">Submit Request</button>
            </form>
        </section>

        <section class="card">
            <h2 class="card-title">Submitted Requests</h2>
            @if ($requests->isEmpty())
                <p class="empty">No document requests yet.</p>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Requestor</th>
                                <th>Document Type</th>
                                <th>Purpose</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td class="row-id">{{ $request->id }}</td>
                                    <td>{{ $request->requestor_name }}</td>
                                    <td>{{ $request->document_type }}</td>
                                    <td>{{ $request->purpose }}</td>
                                    <td><span class="status">{{ $request->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</body>
</html>