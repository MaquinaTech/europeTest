@extends('layouts.app')

@section('title', 'Editar Perro')
<head>
    <meta charset="utf-8">
    <title>Editar Perro</title>
    <link href="/css/styles.css" rel="stylesheet">
</head>
@section('content')
<div id="app" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <editdog :perro="{{ json_encode($perro) }}"></editdog>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('js/app.js') }}"></script>
@endsection
