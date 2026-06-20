@extends('layouts.admin')

@section('title', 'Profile Saya')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
                <h5 class="mb-0">Profile Saya</h5>
            </div>
            <div class="card-body text-center">
                <img src="https://picsum.photos/seed/{{ $user->username }}/100/100" alt="Avatar" class="rounded-circle mb-3 shadow">
                
                <h4>{{ $user->name }}</h4>

                <hr>

                <div class="text-start">
                    <div class="mb-2">
                        <strong>Nama:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Username:</strong> {{ $user->username }}
                    </div>
                    <div class="mb-2">
                        <strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d F Y') }}
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection