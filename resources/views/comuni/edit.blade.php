@extends('templates.layout')
@section('title')
Modifica Comune di: {{ $comuni->nomecomune }}
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
                    <h1 class="text-primary">MODIFICA COMUNE</h1>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                    <a href="/comuni"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-arrow-left-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 8 8 12 12 16"></polyline>
                                <line x1="16" y1="12" x2="8" y2="12"></line>
                            </svg> Lista dei Comuni</button></a>
                </div>
            </div>
            <div class="widget-content widget-content-area mb-5">
                <form action="{{ route('comuni.update', $comuni->id) }}" method="POST" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    <div class="form-row">
                        <div class="col-md-4 mb-4">
                            <label for="nomeComune">Denominazione Comune*</label>
                            <input type="text" class="form-control" name="nomeComune" id="nomeComune"
                                placeholder="Inserisci la denominazione del comune"
                                value="{{ $comuni->nomecomune }}" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="nomeResponsabile">Nome Responsabile</label>
                            <input type="text" class="form-control" name="nomeResponsabile" id="nomeResponsabile"
                                placeholder="Inserisci il nome dell'attuale Responsabile"
                                value="{{ $comuni->responsabile }}">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="numeroTelefono">Numero di Telfono</label>
                            <input type="text" class="form-control" name="numeroTelefono" id="numeroTelefono" placeholder="Inserisci Numero di telefono" value="{{ $comuni->numerotelefono }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9 mb-4">
                            <label for="indirizzoComune">Indirizzo*</label>
                            <input type="text" class="form-control" name="indirizzoComune" id="indirizzoComune"
                                placeholder="Inserisci l'indirizzo del Comune"
                                value="{{ $comuni->indirizzo }}">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="capComune">CAP*</label>
                            <input type="text" class="form-control" name="capComune" id="capComune" placeholder="CAP"
                                value="{{ $comuni->cap }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <label for="urlComuniItalia">Url Comuni Italiani</label>
                            <input type="text" class="form-control" name="urlComuniItalia" id="indirizzoComune" placeholder="Inserisci il link a Comuni d'Italia" value="{{ $comuni->urlext }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="urlMappa">Url Mappa Google</label>
                            <input type="text" class="form-control" name="urlMappa" id="urlMappa" placeholder="Inserisci il link alla mappa di Google" value="{{ $comuni->urlmappa }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-4">
                            <label for="descrizione">Descrizione</label>
                            <textarea row="5" type="text" class="form-control" name="descrizione" id="descrizione" placeholder="Inserisci delle note sul comune">{{ $comuni->descrizione }}</textarea>
                        </div>
                    </div>
                    <div class="form-group my-4">
                        @if($comuni->pathImage ?? '')
                            <img src="{{ asset($comuni->pathcomunelogo) }}"
                                alt="Logo - {{ $comuni->nomecomune }}" height="120px" title="Logo: {{ $comuni->nomecomune }}">
                        @endif
                        <div class="form-group col-md-4 my-4">
                            <label for="caricaLogo">Logo Comune</label>
                            <input type="file" name="caricaLogo" class="form-control-file" id="caricaLogo">
                        </div>
                        <hr>
                    </div>
                    {{ csrf_field() }}
                    <button class="btn btn-primary mt-3" type="submit">Salva</button>
                </form>
            </div>
        </div>
        @component('components.footer')
        @endcomponent
    </div>
    @stop