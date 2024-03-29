@extends('layouts.app')

@section('title', 'Projects')

@section('content')

    <header class="d-flex align-items-center justify-content-between">
        <h1>PROGETTI ELEMINATI</h1>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-primary">
            Vedi progetti attivi
        </a>
    </header>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Stato</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-danger">
                            Svuota cestino
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
                    <td>{{ $project->is_published ? 'Pubblicato' : 'Bozza' }}</td>
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

                            <form action="{{ route('admin.projects.drop', $project->id) }}" method="POST"
                                class="delete-form" data-bs-toggle="modal" data-bs-target="#modal">
                                @CSRF
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash-can"></i></button>
                            </form>

                            <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST"
                                class="delete-form">
                                @CSRF
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success"><i
                                        class="fas fa-arrows-rotate"></i></button>
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
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
