@extends('templates.layout')
@section('title')
Lista Infopoint
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
  <style>
    #map {
        width: 100%;
        height: 300px;
    }
</style>
@stop
@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
            </nav>
        </div>
        <div class="row">
            @if(session()->has('message'))
            <div class="col-xl-12 col-lg-12 col-sm-12  alert {{ session()->get('color') }} mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                <strong>OK</strong> {{ session()->get('message') }}</button>
            </div>
            @endif
        </div>
        <div class="row mt-4">
            <div id="map" class="mt-2 mb-5"></div>
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <h1 class="text-primary">Infopoint</h1>
            </div>
            {{ Auth::user()->getUserInfopointId() }}
        </div>
        <div class="row layout-top-spacing" id="cancel-row">          
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Comune</th>
                                <th>Denominazione</th>
                                <th>Indirizzo</th>
                                <th>CAP</th>
                                <th>Numero di Telefono</th>
                                <th>Mappa</th>
                                <th class="dt-no-sorting">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infopoint as $infop)
                                <tr class="infopoint-item">
                                    <td>{{ $comuni->find($infop->comune_id, "id")->nomecomune }}</td>
                                    <td>{{ $infop->denominazione }}</td>
                                    <td>{{ $infop->indirizzo }}</td>
                                    <td>{{ $infop->cap }}</td>
                                    <td>{{ $infop->numerotelefono }}</td>
                                    <td><a href="{{ $infop->urlmappa }}" target="_new">Link Mappa</a></td>
                                    <td class="text-center">
                                        @if(Auth::user()->getUserInfopointId() === $infop->comune_id || Auth::user()->isAdmin())
                                            <a href="/infopoint/{{ $infop->id }}/edit" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifica"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                        @endif
                                        @if(Auth::user()->getUserInfopointId() === $infop->comune_id || Auth::user()->isAdmin())
                                            <a href="/infopoint/{{ $infop->id }}/filesinfopoint" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="File"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @component('components.footer')
    @endcomponent
</div>
@stop

@section('page-script')
<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
<script src="/plugins/table/datatable/datatables.js"></script>
<!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
<script src="/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="/plugins/table/datatable/button-ext/jszip.min.js"></script>    
<script src="/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="/plugins/table/datatable/button-ext/buttons.print.min.js"></script>
<script>
    $('#html5-extension').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        buttons: {
            buttons: [
                { extend: 'csv', className: 'btn btn-sm' },
                { extend: 'excel', className: 'btn btn-sm' },
                { extend: 'print', className: 'btn btn-sm' }
            ]
        },
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Visualizza la pagina _PAGE_ di _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Cerca...",
           "sLengthMenu": "Risultati :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    } );
</script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
  <script>
	var map = L.map('map').setView([{{ $infopoint->first()->latitudine ?? '42.1003391' }}, {{ $infopoint->first()->longitudine ?? '13.2285044' }}], @if(!empty($infopoint->first()->latitudine) && !empty($infopoint->first()->latitudine) ) 14 @else 7 @endif);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

	var LeafIcon = L.divIcon({
            className: 'marker-icon',
            iconUrl: '/img/icons/infopoint.png',
			iconSize:     [38, 38],
            iconAnchor:   [19, 38],
			popupAnchor:  [0, 0]
	});
	
	@foreach($infopoint as $infop)
		L.marker([{{ $infop->latitudine }}, {{ $infop->longitudine }}], {divIcon: LeafIcon}).bindPopup("<strong class='text-info'>Indirizzo: {{ $infop->indirizzo }} </strong><hr><p class='p-pin'>Numero Telefono: {{ $infop->numerotelefono}}</p>@if($infop->pathImage)<img class='img-pin' src='{{ asset($infop->pathinfopoint) }}' alt='Imagine Infopoint {{ $infop->denominazione }}'>@endif").addTo(map);
	@endforeach
</script>
@stop

