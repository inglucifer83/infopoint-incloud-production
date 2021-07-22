@extends('templates.layout')
@section('title')
    News
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/assets/css/elements/alert.css">
@stop
@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
            </nav>
        </div>
        <div class="row mt-4 mb-5">
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <h1 class="text-primary title-infopoint">Nuova News</h1> 
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
              <a href="/news"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Lista News</button></a>
            </div>
        </div>
        <div class="widget-content widget-content-area">
                    <div class="form-row">
                <div class="form-group col-md-6 mb-4">
                    <label for="inputTitolo">Titolo News *</label>
                    <input type="text" class="form-control" name="inputTitolo" id="inputTitolo" value="{{ $news->title?$news->title:'' }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="tipoNews">Tipo News *</label>
                    <input type="text" class="form-control" name="tipoNews" id="tipoNews" value="{{ $tiponews->find($news->tiponews_id, "id")->descrizione }}">
                </div>
            </div>
                <div class="form-group col-md-12">
                    <label for="inputDescrizione">Descrizione *</label>
                    <textarea type="text" class="form-control" name="inputDescrizione" id="inputDescrizione">{{ $news->descrizione?$news->descrizione:'' }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        @if($news->pathFile)
                        <h5>Visualizza File Collegato</h5>
                        <a href="{{ asset($news->pathfilenews) }}" target="_new"><img src="/img/icons/file-download.png"
                             alt="File Principale" style="height:130px"></a>
                    @endif
                    </div>
                </div>
                </div>

    </div>
    @component('components.footer')
    @endcomponent
</div>
@stop
@section('page-script')

@stop