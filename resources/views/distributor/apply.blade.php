@extends('layouts.app')

@section('title', 'Become a Distributor - Proden')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="mb-2">Become a Proden Distributor</h1>
                    <p class="text-muted mb-4">Partner with us and distribute quality Hibiscus and Passion products in your area.</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Tell us where your shop is, registration details of your business.
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('distributor.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone Number *</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+256..." required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="business_name">Business Name</label>
                                <input type="text" id="business_name" name="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{ old('business_name') }}">
                                @error('business_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="district">District / Location *</label>
                                <input type="text" id="district" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required>
                                @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="address">Physical Address</label>
                                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="experience">Distribution Experience</label>
                                <textarea id="experience" name="experience" rows="3" class="form-control @error('experience') is-invalid @enderror" placeholder="Tell us about your experience (optional)">{{ old('experience') }}</textarea>
                                @error('experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="message">Shop Location & Registration Details</label>
                                <textarea id="message" name="message" rows="3" class="form-control @error('message') is-invalid @enderror" placeholder="Tell us where your shop is, and registration details of your business.">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-paper-plane me-1"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
