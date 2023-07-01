@extends('layouts.app')

@section('title', 'Crear Perro')
    <head>
        <meta charset="utf-8">
        <title>Crear Perro</title>
        <link href="/css/styles.css" rel="stylesheet">
    </head>
@section('content')
    <div id="app" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <createdog></createdog>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{ asset('js/app.js') }}"></script>
@endsection
