@extends('layouts.app')

@section('title', 'Dashboard - Document Request System')
@section('body-class', 'dashboard-page')

@section('content')
    @include('partials.global-header')

    <main class="container">
        @if (session('success'))
            <div class="success" role="status">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (auth()->user()->isStudent())
            @php
                $total = $requests->count();
                $pending = $requests->where('status', 'pending')->count();
                $approved = $requests->where('status', 'approved')->count();
                $rejected = $requests->where('status', 'rejected')->count();
            @endphp

            <header class="page-header">
                <div>
                    <h1 class="page-title">My Document Requests</h1>
                    <p class="page-subtitle">Submit a new request and track the status of everything you have filed.</p>
                </div>
            </header>

            <section class="stats-grid" aria-label="Request summary">
                <div class="stat-card">
                    <span class="stat-label"><i class="stat-dot"></i>Total Requests</span>
                    <span class="stat-value">{{ $total }}</span>
                </div>
                <div class="stat-card tone-pending">
                    <span class="stat-label"><i class="stat-dot"></i>Pending</span>
                    <span class="stat-value">{{ $pending }}</span>
                </div>
                <div class="stat-card tone-approved">
                    <span class="stat-label"><i class="stat-dot"></i>Approved</span>
                    <span class="stat-value">{{ $approved }}</span>
                </div>
                <div class="stat-card tone-rejected">
                    <span class="stat-label"><i class="stat-dot"></i>Rejected</span>
                    <span class="stat-value">{{ $rejected }}</span>
                </div>
            </section>

            @include('partials.student-dashboard')
        @elseif (auth()->user()->isAdministrator())
            @php
                $total = $requests->count();
                $pending = $requests->where('status', 'pending')->count();
                $approved = $requests->where('status', 'approved')->count();
                $rejected = $requests->where('status', 'rejected')->count();
            @endphp

            <header class="page-header">
                <div>
                    <h1 class="page-title">Request Administration</h1>
                    <p class="page-subtitle">Review pending submissions, update statuses, and audit the full request history.</p>
                </div>
            </header>

            <section class="stats-grid" aria-label="Request summary">
                <div class="stat-card">
                    <span class="stat-label"><i class="stat-dot"></i>All Records</span>
                    <span class="stat-value">{{ $total }}</span>
                </div>
                <div class="stat-card tone-pending">
                    <span class="stat-label"><i class="stat-dot"></i>Awaiting Review</span>
                    <span class="stat-value">{{ $pending }}</span>
                </div>
                <div class="stat-card tone-approved">
                    <span class="stat-label"><i class="stat-dot"></i>Approved</span>
                    <span class="stat-value">{{ $approved }}</span>
                </div>
                <div class="stat-card tone-rejected">
                    <span class="stat-label"><i class="stat-dot"></i>Rejected</span>
                    <span class="stat-value">{{ $rejected }}</span>
                </div>
            </section>

            @include('partials.administrator-dashboard')
        @endif
    </main>
@endsection
