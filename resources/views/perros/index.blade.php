@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <example :perros="{{ json_encode($perros) }}"></example>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endsection
