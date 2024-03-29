@extends('layouts.app')

@section('title', 'Projects')

@section('content')

    <header class="d-flex align-items-center justify-content-between">
        <h1>PROGETTI</h1>

        <a href="{{ route('admin.projects.trash') }}">Cestino</a>

        {{-- Filtro --}}
        <form action="{{ route('admin.projects.index') }}" method="GET">
            <div class="input-group">
                <select class="form-select" name='filter'>
                    <option value="">Tutti</option>
                    <option value="published" @if ($filter === 'published') selected @endif>Pubblicati</option>
                    <option value="drafts" @if ($filter === 'drafts') selected @endif>Bozze</option>
                </select>
                <button class="btn btn-outline-secondary">Filtra</button>
            </div>
        </form>
    </header>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Pubblicato</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus me-2"></i>Nuovo progetto
                        </a>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>
                        <form action="{{ route('admin.projects.publish', $project->id) }}" method="POST"
                            class="publication-form" onclick="this.submit()">
                            @CSRF
                            @method('PATCH')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="button"
                                    id="{{ 'is_published-' . $project->id }}"
                                    @if ($project->is_published) checked @endif>
                                <label class="form-check-label"
                                    for="{{ 'is_published-' . $project->id }}">{{ $project->is_published ? 'Pubblicato' : 'Bozza' }}</label>
                            </div>
                        </form>
                    </td>
                    <td>{{ $project->getFormattedDate('created_at') }}</td>
                    <td>{{ $project->getFormattedDate('updated_at') }}</td>
                    <td>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-light">
                                <i class="fas fa-pencil"></i>
                            </a>

                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                class="delete-form" data-bs-toggle="modal" data-bs-target="#modal">
                                @CSRF
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash-can"></i></button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <h3 class="text-center">Non ci sono PROGETTI</h3>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
