@extends('templates.layout')
@section('title')
Dashboard ADMIN
@endsection
@section('page-style')

@stop
@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
            </nav>
        </div>
            <h2>Questa e' la dashborad dell'admin</h2>
    </div>

@component('components.footer')
@endcomponent
</div>
@stop

@section('page-script')
@stop
