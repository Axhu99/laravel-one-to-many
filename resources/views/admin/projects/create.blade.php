@extends('layouts.app')

@section('title', 'Crea Progetto')

@section('content')

    <header>
        <h1>Nuovo Progetto</h1>
    </header>

    @include('includes.projects.form')

@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')

    <script>
        const titleField = document.getElementById('title');
        const slugField = document.getElementById('slug');

        titleField.addEventListener('blur', () => {
            slugField.value = titleField.value.trim().toLowerCase().split(' ').join('-');
        })
    </script>
@endsection
