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
                <h2>Comune: {{ $comuni->nomecomune }}</h2>
            </div>
            @if(Auth::user()->isAdmin())
                <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                    <a href="{{ route('infopoint.create') }}?comune_id={{ $comuni->id }}"><button class="btn btn-success mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Aggiungi Infopoint</button></a>
                </div>
            @endif
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
                                    <td>{{ $comuni->nomecomune }}</td>
                                    <td>{{ $infop->denominazione }}</td>
                                    <td>{{ $infop->indirizzo }}</td>
                                    <td>{{ $infop->cap }}</td>
                                    <td>{{ $infop->numerotelefono }}</td>
                                    <td><a href="{{ $infop->urlmappa }}" target="_new">Link Mappa</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/infopoint/{{ $infop->id }}/edit"><button type="button" class="btn btn-dark btn-sm btn-link">Apri</button></a>
                                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                <a class="dropdown-item" href="/infopoint/{{ $infop->id }}/filesinfopoint">Gestione File</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete-infopoint-a" href="{{ route('infopoint.destroy', $infop->id) }}">Elimina</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4 col-lg-6 col-sm-6 layout-spacing d-flex justify-content-center">
                <a href="{{ route('luoghiinteresse.create') }}?comune_id={{ $comuni->id }}"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sunrise"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="2" x2="12" y2="9"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="8 6 12 2 16 6"></polyline></svg> Aggiungi Luogo Interesse</button></a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6 layout-spacing d-flex justify-content-center">
                <a href="{{ route('strutturericettive.create') }}?comune_id={{ $comuni->id }}"><button class="btn btn-warning mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg> Aggiungi Struttura</button></a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6 layout-spacing d-flex justify-content-center">
                <a href="{{ route('eventi.create') }}?comune_id={{ $comuni->id }}"><button class="btn mb-2 mr-2 btn-lg" style="background-color: #ddf5f0;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Aggiungi Evento</button></a>
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
<script>
    $('document').ready(function(){
              $('div.alert').fadeOut(3000);

              $('.delete-infopoint-a').on('click', function(ele){
                  ele.preventDefault();
                  var urlApp = $(this).attr('href');
                  var tr = $(this).parents('.infopoint-item');
                  if (confirm('Sei sicuro di voler cancellare questo Infopoint ?')) {
                    $.ajax(
                      urlApp,{
                          type: 'delete',
                          data: {
                              '_token' : '{{ csrf_token() }}'
                          },
                          complete : function(resp){                          
                              if(resp.responseText == 1){
                                location.reload();
                              } else {
                                  alert('Problemi di connessione al server!');
                              }
                          }
                      })
                    } else { console.log('cancel')}
              });
          });
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

