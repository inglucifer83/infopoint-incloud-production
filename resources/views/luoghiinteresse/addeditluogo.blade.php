@extends('templates.layout')
@section('title')
    @if($luoghiinteresse->id)
        Modifica Luogo Interesse: {{ $comuni->nomecomune }} - {{ $luoghiinteresse->denominazione }}
    @else
        Nuovo Luogo Interesse: {{ $comuni->nomecomune }}
    @endif
@endsection
@section('page-style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css"
    />
    <link rel="stylesheet" type="text/css" href="/assets/css/elements/alert.css">
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/plugins/editors/quill/quill.snow.css">
    <link href="/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css"/>
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
                    @if($luoghiinteresse->id)
                        <h1 class="text-primary title-infopoint">Modifica Luogo Interesse: {{ $comuni->nomecomune }}
                            - {{ $luoghiinteresse->denominazione }}</h1>
                        <h5>Ultimo Aggiornamento: {{ $luoghiinteresse->updated_at->format('d/m/Y G:i:s') }}</h5>
                    @else
                        <h1 class="text-primary title-infopoint">Nuovo Luogo Interesse: {{ $comuni->nomecomune }}</h1>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                    <a href="/luoghiinteresse">
                        <button class="btn btn-info mb-2 mr-2 btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-arrow-left-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 8 8 12 12 16"></polyline>
                                <line x1="16" y1="12" x2="8" y2="12"></line>
                            </svg>
                            Lista Luoghi Interesse
                        </button>
                    </a>
                </div>
            </div>
            <!-- TABS -->
            <div class="widget-content widget-content-area border-top-tab px-5 bg-white">
                @if($luoghiinteresse->id)
                    <form class="form-input" action="{{ route('luoghiinteresse.update', $luoghiinteresse->id) }}"
                          method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
                        {{ method_field('PATCH') }}
                        @else
                            <form class="form-input" action="{{ route('luoghiinteresse.store') }}" method="POST"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
                                @endif
                                <ul class="nav nav-tabs mb-3 mt-3" id="borderTop" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="border-top-home-tab" data-toggle="tab"
                                           href="#border-top-home" role="tab" aria-controls="border-top-home"
                                           aria-selected="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-home">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            Principale</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-profile-tab" data-toggle="tab"
                                           href="#border-top-profile" role="tab" aria-controls="border-top-profile"
                                           aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-radio">
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path
                                                    d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path>
                                            </svg>
                                            Info Aggiuntive</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-contact-tab" data-toggle="tab"
                                           href="#border-top-contact" role="tab" aria-controls="border-top-contact"
                                           aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-image">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                            Foto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-setting-tab" data-toggle="tab"
                                           href="#border-top-setting" role="tab" aria-controls="border-top-setting"
                                           aria-selected="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-watch">
                                                <circle cx="12" cy="12" r="7"></circle>
                                                <polyline points="12 9 12 12 13.5 13.5"></polyline>
                                                <path
                                                    d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"></path>
                                            </svg>
                                            Orari e Biglietti</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="borderTopContent">
                                    <div class="tab-pane fade active show" id="border-top-home" role="tabpanel"
                                         aria-labelledby="border-top-home-tab">
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="inputDenominazione">Denominazione*</label>
                                                <input type="text" class="form-control" name="inputDenominazione"
                                                       id="inputDenominazione" maxlength="255"
                                                       value="{{ $luoghiinteresse->denominazione?$luoghiinteresse->denominazione:'' }}">
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="inputFrazione">Frazione</label>
                                                <input type="text" class="form-control" name="inputFrazione"
                                                       id="inputFrazione" maxlength="60"
                                                       value="{{ $luoghiinteresse->frazione?$luoghiinteresse->frazione:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="inputIndirizzo">Indirizzo*</label>
                                                <input type="text" class="form-control" name="inputIndirizzo"
                                                       id="inputIndirizzo" maxlength="255"
                                                       value="{{ $luoghiinteresse->indirizzo?$luoghiinteresse->indirizzo:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputLatitudine">Lat. (NN.NNNNNNN)*</label>
                                                <input type="text" class="form-control" name="inputLatitudine"
                                                       id="inputLatitudine"
                                                       value="{{ $luoghiinteresse->latitudine?$luoghiinteresse->latitudine:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputLongitudine">Long. (NN.NNNNNNN)*</label>
                                                <input type="text" class="form-control" name="inputLongitudine"
                                                       id="inputLongitudine"
                                                       value="{{ $luoghiinteresse->longitudine?$luoghiinteresse->longitudine:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-4">
                                                <label for="tipoLuogo">Tipo Luogo*</label>
                                                <select id="tipoLuogo" name="tipoLuogo" class="form-control">
                                                    <option value="" selected>Seleziona...</option>
                                                    @foreach ($tipoluoghiinteresse as $tipoluogo)
                                                        <option
                                                            value="{{ $tipoluogo->id }}" {{ $tipoluogo->id == $luoghiinteresse->tipoluoghiinteresse_id ? 'selected' : '' }}>{{ $tipoluogo->descrizione }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputTelefono">Telefono</label>
                                                <input type="text" class="form-control" name="inputTelefono"
                                                       id="inputTelefono" maxlength="20"
                                                       value="{{ $luoghiinteresse->telefono?$luoghiinteresse->telefono:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" maxlength="120"
                                                       value="{{ $luoghiinteresse->email?$luoghiinteresse->email:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="responsabile">Responsabile</label>
                                                <input type="text" class="form-control" name="responsabile"
                                                       id="responsabile" maxlength="60"
                                                       value="{{ $luoghiinteresse->responsabile?$luoghiinteresse->responsabile:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="border-top-profile" role="tabpanel"
                                         aria-labelledby="border-top-profile-tab">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-4">
                                                <label for="website">Sito Web</label>
                                                <input type="text" class="form-control" name="website" id="website" maxlength="255"
                                                       value="{{ $luoghiinteresse->website?$luoghiinteresse->website:'' }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="urlmappa">Url Mappa</label>
                                                <input type="text" class="form-control" name="urlmappa" id="urlmappa" maxlength="255"
                                                       value="{{ $luoghiinteresse->urlmappa?$luoghiinteresse->urlmappa:'' }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="urlext">Url Extra</label>
                                                <input type="text" class="form-control" name="urlext" id="urlext" maxlength="255"
                                                       value="{{ $luoghiinteresse->urlext?$luoghiinteresse->urlext:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <div class="widget-content widget-content-area">
                                                    <label for="descrizioneEditor">Descrizione</label>
                                                    <div id="descrizioneEditor" 
                                                              name="descrizioneEditor">{!! $luoghiinteresse->descrizione?$luoghiinteresse->descrizione:'' !!}</div>
                                                    <input name="descrizione" id="descrizione"  type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-2">
                                                <div class="widget-content widget-content-area">
                                                    <label for="note">Note</label>
                                                    <textarea type="text" class="form-control" rows="4" id="note"
                                                              name="note">{{ $luoghiinteresse->note?$luoghiinteresse->note:'' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="caricaFile">File</label>
                                                <input type="file" name="caricaFile" class="form-control-file"
                                                       id="caricaFile">
                                            </div>
                                            <div class="form-group col-md-6">
                                                @if($luoghiinteresse->pathFile)
                                                    <h5>Visualizza File Collegato</h5>
                                                    <a href="{{ asset($luoghiinteresse->pathfileluoghiinteresse) }}" target="_new"><img src="/img/icons/file-download.png"
                                                         alt="File Principale" style="height:130px"></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="border-top-contact" role="tabpanel"
                                         aria-labelledby="border-top-contact-tab">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="caricaImg">Immagine Principale</label>
                                                <input type="file" name="caricaImg" class="form-control-file"
                                                       id="caricaImg">
                                            </div>
                                            <div class="form-group col-md-6">
                                                @if($luoghiinteresse->pathImage)
                                                    <img src="{{ asset($luoghiinteresse->pathluoghiinteresse) }}"
                                                         alt="Foto Luogo Interesse">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="custom-file-container" data-upload-id="mySecondImage">
                                            <label>Immagini Addizionali <a href="javascript:void(0)"
                                                                           class="custom-file-container__image-clear"
                                                                           title="Cancella immagini">x</a></label>
                                            <label for="fotoAddizionali" class="custom-file-container__custom-file">
                                                <input accept="image/*" type="file"
                                                       class="custom-file-container__custom-file__custom-file-input"
                                                       id="fotoAddizionali" name="fotoAddizionali[]" multiple>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="2548576"/>
                                                <span
                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>
                                        @if($luoghiinteresse->id)
                                            <div class="row">
                                                @foreach($fotoluoghiinteresse as $fotoluogo)
                                                    <div class="ph-item col-md-4 mt-4">
                                                        <div class="card component-card_2">
                                                            <img src="{{ asset($fotoluogo->pathfotoluoghi) }}" class="card-img-top" alt="widget-card-2">
                                                            <div class="card-body">
                                                                <a href="{{ route('fotoluoghiinteresse.destroy', $fotoluogo->id) }}" class="del-foto-a btn btn-primary">Cancella</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="border-top-setting" role="tabpanel"
                                         aria-labelledby="border-top-setting-tab">
                                        <div class="form-row">
                                            <div class="col-md-2 mb-4">
                                                <label for="costoBiglietto">Costo Biglietto</label>
                                                <input type="text" class="form-control" name="costoBiglietto"
                                                       id="costoBiglietto"
                                                       value="{{ $luoghiinteresse->costobigliettoadulti?$luoghiinteresse->costobigliettoadulti:'' }}">
                                            </div>
                                            <div class="col-md-10 mb-4">
                                                <label for="noteCostoBiglietto">Note Costo Biglietto</label>
                                                <input type="text" class="form-control" name="noteCostoBiglietto"
                                                       id="noteCostoBiglietto" maxlength="255"
                                                       value="{{ $luoghiinteresse->notecostobigliettoadulti?$luoghiinteresse->notecostobigliettoadulti:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-2 mb-4">
                                                <label for="costoBigliettoBambini">Costo Bigl. Bambini</label>
                                                <input type="text" class="form-control" name="costoBigliettoBambini"
                                                       id="costoBigliettoBambini" 
                                                       value="{{ $luoghiinteresse->costobigliettobambini?$luoghiinteresse->costobigliettobambini:'' }}">
                                            </div>
                                            <div class="col-md-10 mb-4">
                                                <label for="noteCostoBigliettoBambini">Note Costo Biglietto
                                                    Bambini</label>
                                                <input type="text" class="form-control" name="noteCostoBigliettoBambini"
                                                       id="noteCostoBigliettoBambini" maxlength="255"
                                                       value="{{ $luoghiinteresse->notecostobigliettobambini?$luoghiinteresse->notecostobigliettobambini:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-2 mb-4">
                                                <label for="costoBigliettoRidotto">Costo Biglietto Ridotto</label>
                                                <input type="text" class="form-control" name="costoBigliettoRidotto"
                                                       id="costoBigliettoRidotto"
                                                       value="{{ $luoghiinteresse->costobigliettoridotto?$luoghiinteresse->costobigliettoridotto:'' }}">
                                            </div>
                                            <div class="col-md-10 mb-4">
                                                <label for="noteCostoBigliettoRidotto">Note Costo Biglietto
                                                    Ridotto</label>
                                                <input type="text" class="form-control" name="noteCostoBigliettoRidotto"
                                                       id="noteCostoBigliettoRidotto" maxlength="255"
                                                       value="{{ $luoghiinteresse->notecostobigliettoridotto?$luoghiinteresse->notecostobigliettoridotto:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <label for="noteGenericheBiglietti">Note Generiche Biglietti</label>
                                                <input type="text" class="form-control" name="noteGenericheBiglietti"
                                                       id="noteGenericheBiglietti"
                                                       value="{{ $luoghiinteresse->notebiglietti?$luoghiinteresse->notebiglietti:'' }}">
                                            </div>
                                        </div>
                                        @if($luoghiinteresse->id)
                                        <div class="row layout-spacing mt-4">
                                            <div class="col-lg-12">
                                                <h2 class="text-center">Orari di Apertura</h2>
                                                <a href="" class='addbtn btn btn-primary btn-block mb-4 mr-2' data-toggle="modal"
                                                   data-placement="top" title="" data-original-title="Aggiungi" data-target="#modalAddOrario">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                         stroke-linejoin="round"
                                                         class="feather feather-clock">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <polyline points="12 6 12 12 16 14"></polyline>
                                                    </svg>
                                                    Aggiungi Orari
                                                </a>
                                                <div class="statbox widget box box-shadow">
                                                    <div class="widget-content widget-content-area">
                                                        <div id="style-3_wrapper"
                                                             class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="style-3"
                                                               class="table style-3 table-hover dataTable no-footer"
                                                               role="grid"
                                                               aria-describedby="style-3_info">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="sorting" tabindex="0" aria-controls="style-3"
                                                                    rowspan="1" colspan="1"
                                                                    style="width: 180px;"
                                                                    aria-label="Nome File: cliccare per ordinare la colonna in modo ascendente">
                                                                    Giorno Settimana
                                                                </th>
                                                                <th class="sorting" tabindex="0" aria-controls="style-3"
                                                                    rowspan="1" colspan="1"
                                                                    style="width: 90px;"
                                                                    aria-label="Estensione: cliccare per ordinare la colonna in modo ascendente">
                                                                    Orario Apertura
                                                                </th>
                                                                <th class="sorting" tabindex="0" aria-controls="style-3"
                                                                    rowspan="1" colspan="1"
                                                                    style="width: 300px;"
                                                                    aria-label="Descrizione: cliccare per ordinare la colonna in modo ascendente">
                                                                    Orario Chiusura
                                                                </th>
                                                                <th class="text-center dt-no-sorting sorting"
                                                                    tabindex="0"
                                                                    aria-controls="style-3" rowspan="1" colspan="1"
                                                                    style="width: 110px;"
                                                                    aria-label="Azioni: cliccare per ordinare la colonna in modo ascendente">
                                                                    Azioni
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="tblorario">
                                                            @foreach ($apertureluoghiinteresse as $aperture)
                                                            <tr role="row" class="files-item">
                                                                    <td>{{ $giornisettimana->find($aperture->giornosettimana_id, "id")->giorno }}</td>
                                                                    <td>{{ date('G:i', strtotime($aperture->orario_apertura)) }}</td>
                                                                    <td>{{ date('G:i', strtotime($aperture->orario_chiusura)) }}</td>
                                                                    <td class="text-center">

                                                                                <a href="{{ route('apertureluoghiinteresse.destroy', $aperture->id)  }}"
                                                                                   class="bs-tooltip delete-orario-a"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top" title=""
                                                                                   data-original-title="Cancella">
                                                                                    <svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-trash p-1 br-6 mb-1">
                                                                                        <polyline
                                                                                            points="3 6 5 6 21 6"></polyline>
                                                                                        <path
                                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                        </path>
                                                                                    </svg>
                                                                                </a>
                                                                    </td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <button type="submit" name='action' value='save' class="btn btn-primary mt-3">SALVA</button>
                            </form>
                            <div id='map' class="mt-2 mb-1"></div>
                            <!-- Modal Aggiunta File-->
                            <div class="modal fade" id="modalAddOrario" tabindex="-1" role="dialog"
                                 aria-labelledby="modalAddOrarioLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAddOrarioLabel">Aggiungi Orario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="modalAddOrarioForm" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="luogointeresse_id" value="{{ $luoghiinteresse->id }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-row">
                                                    <div class="col-md-12 mb-4">
                                                        <label for="giornoSettimana">Giorno Settimana</label>
                                                        <select id="giornoSettimana" name="giornoSettimana" class="form-control" required>
                                                            <option value="" selected>Seleziona...</option>
                                                            @foreach ($giornisettimana as $giorno)
                                                                <option
                                                                    value="{{ $giorno->id }}">{{ $giorno->giorno }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-4">
                                                        <label for="oraApertura">Orario Apertura</label>
                                                        <select id="oraApertura" name="oraApertura" class="form-control" required>
                                                            <option value="" selected>Seleziona...</option>
                                                            @foreach ($orari as $orario)
                                                                <option
                                                                    value="{{ $orario->orario }}">{{ date('G:i', strtotime($orario->orario)) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label for="oraChiusura">Orario Chiusura</label>
                                                        <select id="oraChiusura" name="oraChiusura" class="form-control" required>
                                                            <option value="" selected>Seleziona...</option>
                                                            @foreach ($orari as $orario)
                                                                <option
                                                                    value="{{ $orario->orario }}">{{ date('G:i', strtotime($orario->orario)) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Annulla
                                                    </button>
                                                    <button type="submit"  class="btn btn-primary">Salva</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
            <!-- FINE TABS -->
            @component('components.footer')

            @endcomponent
        </div>
        @stop
        @section('page-script')
            <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                    crossorigin=""></script>
            <script src="https://unpkg.com/leaflet-geosearch@3.3.1/dist/geosearch.umd.js"></script>
            <script>
                //AGGIUNGI
                $(document).ready(function(){
                    $('.addbtn').on('click', function(){
                        $('#modalAddOrario').modal('show');
                    });
                    $('#modalAddOrarioForm').on('submit', function(e){
                        e.preventDefault();
                        var giorno = $('#giornoSettimana').children(':selected').text();
                        var oraApe = $('#oraApertura').children(':selected').text();
                        var oraChiu = $('#oraChiusura').children(':selected').text();
                        console.log(giorno);
                        $.ajax({
                            type: "POST",
                            url:"/apertureluoghiinteresse",
                            data: $('#modalAddOrarioForm').serialize(),
                            success: function(response){
                                var formOrario = $('#tblorario');

                                formOrario.append('<tr role="row" class="files-item"><td>'+giorno+'</td><td>'+oraApe+'</td><td>'+oraChiu+'</td><td class="text-center"></td></tr>');
                                $('#modalAddOrario').modal('hide');
                            },
                            error: function(error){
                                console.log(error);
                                alert("Salvataggio non riuscito");
                            }

                        })
                        console.log($('#modalAddOrarioForm').serialize());
                    });
                });
            </script>
            <script>
                $('document').ready(function(){

                    $('.delete-orario-a').on('click', function(ele){
                        ele.preventDefault();
                        var urlApp = $(this).attr('href');
                        var tr = $(this).parents('.files-item');
                        if (confirm('Sei sicuro di voler cancellare questo File ?')) {
                            $.ajax(
                                urlApp,{
                                    type: 'delete',
                                    data: {
                                        '_token' : '{{ csrf_token() }}'
                                    },
                                    complete : function(resp){
                                        if(resp.responseText == 1){
                                            tr.remove();
                                        } else {
                                            alert('Problemi di connessione al server!');
                                        }
                                    }
                                })
                        } else { console.log('cancel')}
                    });
                });
            </script>
            <script>
                $('document').ready(function(){
                    //Cancellazione foto
                    $('.del-foto-a').on('click', function(ele){
                        ele.preventDefault();
                        var urlAppPh = $(this).attr('href');
                        var divPh = $(this).parents('.ph-item');
                        if (confirm('Sei sicuro di voler cancellare questa Foto ?')) {
                            $.ajax(
                                urlAppPh,{
                                    type: 'delete',
                                    data: {
                                        '_token' : '{{ csrf_token() }}'
                                    },
                                    complete : function(resp){
                                        if(resp.responseText == 1){
                                            divPh.remove();
                                        } else {
                                            alert('Problemi di connessione al server!');
                                        }
                                    }
                                })
                        } else { console.log('cancel')}
                    });
                });
            </script>
            <script>
                $(function () {
                    // use below if you want to specify the path for leaflet's images
                    //L.Icon.Default.imagePath = '@Url.Content("~/Content/img/leaflet")';

                    @if($luoghiinteresse->id)
                    var curLocation = [{{ $luoghiinteresse->latitudine }}, {{ $luoghiinteresse->longitudine }}];
                    @else
                    var curLocation = [0, 0];
                    @endif

                    // use below if you have a model
                    // var curLocation = [@Model.Location.Latitude, @Model.Location.Longitude];

                    if (curLocation[0] == 0 && curLocation[1] == 0) {
                        curLocation = [40.2455477, 15.5562326];
                    }

                    var map = L.map('map').setView(curLocation, 10);

                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    const provider = new GeoSearch.OpenStreetMapProvider();

                    const form = document.querySelector('form.form-input');
                    const input = form.querySelector('#inputIndirizzo');

                    document.querySelector('#inputIndirizzo').addEventListener('keypress', async (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const results = await provider.search({query: input.value});
                            $("#inputLatitudine").val(results[0].y);
                            $("#inputLongitudine").val(results[0].x);
                            var position = [parseFloat($("#inputLatitudine").val()), parseFloat($("#inputLongitudine").val())];
                            marker.setLatLng(position, {
                                draggable: 'true'
                            }).bindPopup(position).update();
                            map.panTo(position);
                            console.log(results);
                        }
                    });
                    map.attributionControl.setPrefix(false);

                    var marker = new L.marker(curLocation, {
                        draggable: 'true'
                    });

                    marker.on('dragend', function (event) {
                        var position = marker.getLatLng();
                        marker.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                        $("#inputLatitudine").val(position.lat);
                        $("#inputLongitudine").val(position.lng).keyup();
                    });
                    $("#inputLatitudine, #inputLongitudine").change(function () {
                        var position = [parseInt($("#inputLatitudine").val()), parseInt($("#inputLongitudine").val())];
                        marker.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                        map.panTo(position);
                    });
                    map.addLayer(marker);
                })
            </script>
            <script src="/assets/js/scrollspyNav.js"></script>
            <script src="/plugins/editors/quill/quill.js"></script>
            <script src="/plugins/editors/quill/custom-quill.js"></script>
            <script src="/plugins/file-upload/file-upload-with-preview.min.js"></script>
            <script>
                var secondUpload = new FileUploadWithPreview('mySecondImage')
            </script>
@stop
