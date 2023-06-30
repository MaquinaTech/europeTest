@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <example :perros="{{ json_encode($perros) }}"></example>

            </div>
        </div>
    </div>
</div>

@endsection
