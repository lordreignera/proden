@extends('layouts.admin')

@section('title', 'Distributors - Proden Admin')
@section('page-title', 'Distributor Applications')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-user-tie"></i> Distributor Leads</span>
        <span class="badge bg-primary">{{ $applications->total() }} total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Applicant</th>
                    <th>Contact</th>
                    <th>Business / District</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td>{{ $application->created_at->format('d M Y') }}</td>
                        <td>
                            <strong>{{ $application->full_name }}</strong>
                            @if($application->experience)
                                <br><small class="text-muted">Has experience</small>
                            @endif
                        </td>
                        <td>
                            <div>{{ $application->phone }}</div>
                            @if($application->email)
                                <small class="text-muted">{{ $application->email }}</small>
                            @endif
                        </td>
                        <td>
                            <div>{{ $application->business_name ?: 'N/A' }}</div>
                            <small class="text-muted">{{ $application->district }}</small>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($application->status) {
                                    'new' => 'secondary',
                                    'contacted' => 'warning text-dark',
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($application->status) }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.distributors.status', $application) }}" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" style="min-width: 130px;">
                                    <option value="new" @selected($application->status === 'new')>New</option>
                                    <option value="contacted" @selected($application->status === 'contacted')>Contacted</option>
                                    <option value="approved" @selected($application->status === 'approved')>Approved</option>
                                    <option value="rejected" @selected($application->status === 'rejected')>Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                            </form>
                        </td>
                    </tr>
                    @if($application->address || $application->message || $application->experience)
                        <tr>
                            <td></td>
                            <td colspan="5" class="small text-muted bg-light">
                                @if($application->address)<div><strong>Address:</strong> {{ $application->address }}</div>@endif
                                @if($application->experience)<div><strong>Experience:</strong> {{ $application->experience }}</div>@endif
                                @if($application->message)<div><strong>Message:</strong> {{ $application->message }}</div>@endif
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox"></i> No distributor applications yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-center">
            {{ $applications->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
