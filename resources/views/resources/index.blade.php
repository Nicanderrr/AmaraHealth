@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Trusted support points',
    'title' => 'Know where to go before it feels urgent',
    'description' => 'Find clinics, services, and local contacts that can help you move from uncertainty to real care.',
])

<section class="container pb-5">
    <div class="stack-grid cols-3">
        @forelse ($resources as $resource)
            <div class="panel-card p-4 h-100">
                <span class="theme-pill">{{ $resource->service_type }}</span>
                <h3 class="mt-3">{{ $resource->name }}</h3>
                <p class="text-muted">{{ $resource->description }}</p>
                <hr>
                <p class="mb-1"><strong>Location:</strong> {{ $resource->location }}</p>
                @if ($resource->contact_phone)<p class="mb-1"><strong>Phone:</strong> {{ $resource->contact_phone }}</p>@endif
                @if ($resource->contact_email)<p class="mb-1"><strong>Email:</strong> {{ $resource->contact_email }}</p>@endif
                @if ($resource->website)<p class="mb-0"><a href="{{ $resource->website }}" target="_blank" rel="noreferrer">Website</a></p>@endif
            </div>
        @empty
            <p>No verified resources yet.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $resources->links() }}</div>
</section>
@endsection
