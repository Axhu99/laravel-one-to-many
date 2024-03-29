@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <header>
        <h1>Boolpress</h1>
        <h3>Scopri i miei progetti</h3>
    </header>

    @forelse ($projects as $project)
        <div class="card my-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                {{ $project->title }}

                <a href="{{ route('guest.projects.show', $project->slug) }}" class="btn btn-sm btn-primary">Vedi</a>
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
    @empty
        <h3 class="text-center">Non ci sono progetti</h3>
    @endforelse

@endsection
