@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'eyebrow' => 'Ask safely',
    'title' => 'Share the question you have been holding back',
    'description' => 'Choose an alias, explain what is on your mind, and keep your real name out of the public discussion.',
])

<section class="container pb-5">
    <div class="panel-card p-4 p-lg-5 mx-auto" style="max-width: 860px;">
        <form method="post" action="{{ route('forum.store') }}" class="stack-grid">
            @csrf
            <div>
                <label class="form-label">Alias</label>
                <input name="anonymous_name" type="text" value="{{ old('anonymous_name') }}" class="form-control theme-input" placeholder="Anonymous Lotus">
            </div>
            <div>
                <label class="form-label">Topic title</label>
                <input name="title" type="text" value="{{ old('title') }}" class="form-control theme-input" required>
            </div>
            <div>
                <label class="form-label">Details</label>
                <textarea name="body" rows="7" class="form-control theme-input" required>{{ old('body') }}</textarea>
            </div>
            <button class="thm-btn">
                <span class="thm-btn-text">Publish topic</span>
                <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
            </button>
        </form>
    </div>
</section>
@endsection
