@extends('templates.layout')
@section('title')
    Nuova Informazione
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
        @if(count($errors))
                @foreach ( $errors->all() as $error)
                    <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        <div class="row mt-4 mb-5">
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <h1 class="text-primary title-infopoint">Nuova Informazione</h1> 
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
              <a href="/news"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Lista Informazioni</button></a>
            </div>
        </div>
        <div class="widget-content widget-content-area">
                <form class="form-input" action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-row">
                <div class="form-group col-md-6 mb-4">
                    <label for="inputTitolo">Titolo Informazione *</label>
                    <input type="text" class="form-control" name="inputTitolo" id="inputTitolo" maxlength="255" value="{{ $news->title?$news->title:'' }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="tipoNews">Tipo Informazione *</label>
                    <select id="tipoNews" name="tipoNews" class="form-control" required>
                        <option value="" selected>Seleziona...</option>
                        @foreach ($tiponews as $tipnw)
                            <option
                                value="{{ $tipnw->id }}">{{ $tipnw->descrizione }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="form-group col-md-12">
                    <label for="inputDescrizione">Descrizione *</label>
                    <textarea type="text" class="form-control" name="inputDescrizione" id="inputDescrizione">{{ $news->descrizione?$infopoint->descrizione:'' }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="caricaFile">File</label>
                        <input type="file" name="caricaFile" class="form-control-file"
                               id="caricaFile">
                    </div>
                    <div class="form-group col-md-6">
                        @if($news->pathFile)
                        <h5>Visualizza File Collegato</h5>
                        <a href="{{ asset($news->pathfilenews) }}" target="_new"><img src="/img/icons/file-download.png"
                             alt="File Principale" style="height:130px"></a>
                    @endif
                    </div>
                </div>
                </div>
              <button class="btn btn-primary mt-3" type="submit">Salva</button>
            </form>
        </div>

    </div>
    @component('components.footer')
    @endcomponent
</div>
@stop
@section('page-script')

@stop
