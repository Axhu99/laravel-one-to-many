@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <header>
        <h1>Boolpress</h1>
    </header>

    <div class="card my-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            {{ $project->title }}
        </div>
        <div class="card-body">
            <div class="row">
                @if ($project->image)
                    <div class="col-3">
                        <img src="{{ $project->printImage() }}" alt="{{ $project->title }}">
                    </div>
                @endif
                <div class="col">
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $project->create_at }}</h6>
                    <p class="card-text">{{ $project->content }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
