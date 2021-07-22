@extends('templates.layout')
@section('title')
    @if($eventi->id)
        Modifica Evento: {{ $eventi->denominazione }} - Comune: {{ $comuni->nomecomune }}
    @else
        Nuovo Evento Comune: {{ $comuni->nomecomune }}
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
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
        .img-evento{
            max-height: 350px;
        }
    </style>
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/plugins/editors/quill/quill.snow.css">
    <link href="/plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <link href="/plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
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
                    @if($eventi->id)
                        <h1 class="text-primary title-infopoint">Modifica Evento: {{ $comuni->nomecomune }} - {{ $eventi->denominazione }}</h1>
                            <h5>Ultimo Aggiornamento: {{ $eventi->updated_at->format('d/m/Y G:i:s') }}</h5>
                    @else
                        <h1 class="text-primary title-infopoint">Nuovo Evento nel comune: {{ $comuni->nomecomune }}</h1>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                    <a href="/eventi">
                        <button class="btn btn-info mb-2 mr-2 btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-arrow-left-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 8 8 12 12 16"></polyline>
                                <line x1="16" y1="12" x2="8" y2="12"></line>
                            </svg>
                            Lista Eventi
                        </button>
                    </a>
                </div>
            </div>
            <!-- TABS -->
            <div class="widget-content widget-content-area border-top-tab px-5 bg-white">
                @if($eventi->id)
                    <form class="form-input" action="{{ route('eventi.update', $eventi->id) }}"
                          method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
                        {{ method_field('PATCH') }}
                        @else
                            <form class="form-input" action="{{ route('eventi.store') }}" method="POST"
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
                                </ul>
                                <div class="tab-content" id="borderTopContent">
                                    <div class="tab-pane fade active show" id="border-top-home" role="tabpanel"
                                         aria-labelledby="border-top-home-tab">
                                         <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="caricaImg">Immagine Principale</label>
                                                <input type="file" name="caricaImg" class="form-control-file"
                                                       id="caricaImg">
                                            </div>
                                            <div class="form-group col-md-6">
                                                @if($eventi->pathImage)
                                                    <img class="img-evento" src="{{ asset($eventi->pathluoghiinteresse) }}"
                                                         alt="Foto Evento">
                                                @endif
                                            </div>
                                         </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="inputDenominazione">Denominazione*</label>
                                                <input type="text" class="form-control" name="inputDenominazione"
                                                       id="inputDenominazione" maxlength="255"
                                                       value="{{ $eventi->denominazione?$eventi->denominazione:'' }}">
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="inputFrazione">Frazione</label>
                                                <input type="text" class="form-control" name="inputFrazione"
                                                       id="inputFrazione" maxlength="60"
                                                       value="{{ $eventi->frazione?$eventi->frazione:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <label for="inputIndirizzo">Indirizzo*</label>
                                                <input type="text" class="form-control" name="inputIndirizzo"
                                                       id="inputIndirizzo" maxlength="255"
                                                       value="{{ $eventi->indirizzo?$eventi->indirizzo:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputLatitudine">Lat. (NN.NNNNNNN)*</label>
                                                <input type="text" class="form-control" name="inputLatitudine"
                                                       id="inputLatitudine"
                                                       value="{{ $eventi->latitudine?$eventi->latitudine:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputLongitudine">Long. (NN.NNNNNNN)*</label>
                                                <input type="text" class="form-control" name="inputLongitudine"
                                                       id="inputLongitudine"
                                                       value="{{ $eventi->longitudine?$eventi->longitudine:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-4">
                                                <label for="tipoEvento">Tipo Evento</label>
                                                <select id="tipoEvento" name="tipoEvento" class="form-control">
                                                    <option value="" selected>Seleziona...</option>
                                                    @foreach ($tipoeventi as $tipoevento)
                                                        <option
                                                            value="{{ $tipoevento->id }}" {{ $tipoevento->id == $eventi->tipoeventi_id ? 'selected' : '' }}>{{ $tipoevento->descrizione }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="inputTelefono">Telefono</label>
                                                <input type="text" class="form-control" name="inputTelefono"
                                                       id="inputTelefono" maxlength="20"
                                                       value="{{ $eventi->telefono?$eventi->telefono:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" maxlength="120"
                                                       value="{{ $eventi->email?$eventi->email:'' }}">
                                            </div>
                                            <div class="col-md-3 mb-4">
                                                <label for="responsabile">Responsabile</label>
                                                <input type="text" class="form-control" name="responsabile"
                                                       id="responsabile" maxlength="60"
                                                       value="{{ $eventi->responsabile?$eventi->responsabile:'' }}">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4 mb-0">
                                                    <label for="dataInizio">Data Inizio Evento</label>
                                                    @if($eventi->id)
                                                        <input id="dataInizio" name="dataInizio" value="{!! date("d-m-Y", strtotime($eventi->inizio_evento)) !!}" class="form-control flatpickr flatpickr-input" type="text" placeholder="Data Inizio" readonly="readonly">
                                                    @else
                                                        <input id="dataInizio" name="dataInizio" value="{!! date("d-m-Y") !!}" class="form-control flatpickr flatpickr-input" type="text" placeholder="Data Inizio" readonly="readonly">
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-4 mb-0">
                                                    <label for="dataFine">Data Fine Evento</label>
                                                    @if($eventi->id)
                                                        <input id="dataFine" name="dataFine" value="{!! date("d-m-Y", strtotime($eventi->fine_evento))  !!}" class="form-control flatpickr flatpickr-input" type="text" placeholder="Data Fine" readonly="readonly">
                                                    @else
                                                        <input id="dataFine" name="dataFine" value="{!! date("d-m-Y") !!}" class="form-control flatpickr flatpickr-input" type="text" placeholder="Data Inizio" readonly="readonly">
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="border-top-profile" role="tabpanel"
                                         aria-labelledby="border-top-profile-tab">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-4">
                                                <label for="website">Sito Web</label>
                                                <input type="text" class="form-control" name="website" id="website" maxlength="255"
                                                       value="{{ $eventi->website?$eventi->website:'' }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="urlmappa">Url Mappa</label>
                                                <input type="text" class="form-control" name="urlmappa" id="urlmappa" maxlength="255"
                                                       value="{{ $eventi->urlmappa?$eventi->urlmappa:'' }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="urlext">Url Extra</label>
                                                <input type="text" class="form-control" name="urlext" id="urlext" maxlength="255"
                                                       value="{{ $eventi->urlext?$eventi->urlext:'' }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-4">
                                                <div class="widget-content widget-content-area">
                                                    <label for="descrizioneEditor">Descrizione</label>
                                                    <div id="descrizioneEditor"
                                                              name="descrizioneEditor">{!! $eventi->descrizione?$eventi->descrizione:'' !!}</div>
                                                    <input name="descrizione" id="descrizione"  type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-2">
                                                <div class="widget-content widget-content-area">
                                                    <label for="note">Note</label>
                                                    <textarea type="text" class="form-control" rows="4" id="note"
                                                              name="note">{{ $eventi->note?$eventi->note:'' }}</textarea>
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
                                                @if($eventi->pathFile)
                                                <h5>Visualizza File Collegato</h5>
                                                <a href="{{ asset($eventi->pathfileluoghiinteresse) }}" target="_new"><img src="/img/icons/file-download.png"
                                                     alt="File Principale" style="height:130px"></a>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <button type="submit" name='action' value='save' class="btn btn-primary mt-3">SALVA</button>
                            </form>
                            <div id='map' class="mt-2 mb-1"></div>
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
                $(function () {
                    // use below if you want to specify the path for leaflet's images
                    //L.Icon.Default.imagePath = '@Url.Content("~/Content/img/leaflet")';
                    @if($eventi->id)
                    var curLocation = [{{ $eventi->latitudine }}, {{ $eventi->longitudine }}];
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
            <script src="/plugins/flatpickr/flatpickr.js"></script>
        <script>
            var f1 = flatpickr(document.getElementById('dataInizio'), {
            enableTime: false,
            dateFormat: 'd-m-Y',
            });
            var f2 = flatpickr(document.getElementById('dataFine'), {
            enableTime: false,
            dateFormat: 'd-m-Y',
            });
        </script>
@stop
