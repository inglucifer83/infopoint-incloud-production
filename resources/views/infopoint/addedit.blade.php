@extends('templates.layout')
@section('title')
@if($infopoint->id)
    Modifica Infopoint: {{ $comuni->nomecomune }} - {{ $infopoint->denominazione }}
@else
    Nuovo Infopoint: {{ $comuni->nomecomune }}
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
        width: 100%px;
        height: 500px;
    }
    .img-profilo{
        max-height: 250px;
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
                @if($infopoint->id)
                    <h1 class="text-primary title-infopoint">Modifica Infopoint: {{ $comuni->nomecomune }} - {{ $infopoint->denominazione }}</h1>
                @else
                    <h1 class="text-primary title-infopoint">Nuovo Infopoint: {{ $comuni->nomecomune }}</h1>
                @endif   
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
              @if(Auth::user()->isAdmin())
                <a href="/comuni/{{ $comuni->id }}/infopoint"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Lista Infopoint {{ $comuni->nomecomune }}</button></a>
              @else
              <a href="/infopoint"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Lista Infopoint</button></a>
              @endif
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div id='map' class="mt-2 mb-1"></div>
            @if($infopoint->id)
                <form class="form-input" action="{{ route('infopoint.update', $infopoint->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
                    {{ method_field('PATCH') }}
            @else
                <form class="form-input" action="{{ route('infopoint.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
            @endif
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <label for="inputIndirizzo">Indirizzo (Inserisci l'indirizzo e premi invio)</label>
                        <input type="text" class="form-control" name="inputIndirizzo" id="inputIndirizzo" value="{{ $infopoint->indirizzo?$infopoint->indirizzo:'' }}">
                    </div>
                    <div class="col-md-2 mb-4">
                      <label for="inputFrazione">Frazione</label>
                      <input type="text" class="form-control" name="inputFrazione" id="inputFrazione" maxlength="60" value="{{ $infopoint->frazione?$infopoint->frazione:'' }}">
                  </div>
                    <div class="col-md-2 mb-4">
                        <label for="inputLatitudine">Lat. (NN.NNNNNNN)</label>
                        <input type="text" class="form-control" name="inputLatitudine" id="inputLatitudine" value="{{ $infopoint->latitudine?$infopoint->latitudine:'' }}">
                    </div>
                    <div class="col-md-2 mb-4">
                        <label for="inputLongitudine">Long. (NN.NNNNNNN)</label>
                        <input type="text" class="form-control" name="inputLongitudine" id="inputLongitudine" value="{{ $infopoint->longitudine?$infopoint->longitudine:'' }}">
                    </div>
                </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4">
                            <label for="denominazioneInfopoint">Denominazione</label>
                            <input type="text" class="form-control" name="denominazioneInfopoint" maxlength="120" id="denominazioneInfopoint" value="{{ $infopoint->denominazione?$infopoint->denominazione:'' }}">
                        </div>
                        <div class="col-md-1 mb-4">
                            <label for="cap">Cap</label>
                            <input type="text" class="form-control" maxlength="5" name="cap" id="cap" value="{{ $infopoint->cap?$infopoint->cap:'' }}">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="responsabile">Responsabile</label>
                            <input type="text" class="form-control" name="responsabile" maxlength="60" id="responsabile" value="{{ $infopoint->responsabile?$infopoint->responsabile:'' }}">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control" name="telefono" maxlength="20" id="telefono" value="{{ $infopoint->numerotelefono?$infopoint->numerotelefono:'' }}">
                        </div>
                    </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="caricaImg">Immagine Infopoint</label>
                        <input type="file" name="caricaImg" class="form-control-file" id="caricaImg">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" maxlength="255" id="email" value="{{ $infopoint->email?$infopoint->email:'' }}">
                    </div>
                    <div class="col-md-5 mb-4">
                      <label for="urlaMappa">Url Mappa</label>
                      <input type="text" class="form-control" name="urlaMappa" maxlength="255" id="urlaMappa" value="{{ $infopoint->urlmappa?$infopoint->urlmappa:'' }}">
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="note">Note</label>
                        <textarea type="text" class="form-control" name="note" id="note">{{ $infopoint->note?$infopoint->note:'' }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        @if($infopoint->pathImage)
                        <img class="img-profilo" src="{{ asset($infopoint->pathinfopoint) }}" alt="Foto Infopoint">
                        @endif
                    </div>
                </div>
              <button class="btn btn-primary mt-3 @if(!Auth::user()->isAdmin()) d-none @endif" type="submit">Salva</button>
            </form>
        </div>

    </div>
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
$(function() {
  // use below if you want to specify the path for leaflet's images
  //L.Icon.Default.imagePath = '@Url.Content("~/Content/img/leaflet")';

  @if($infopoint->id)
    var curLocation = [{{ $infopoint->latitudine }}, {{ $infopoint->longitudine }}];    
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

console.log(form);

document.querySelector('#inputIndirizzo').addEventListener('keypress', async (e) => {
if (e.key === 'Enter') {
	e.preventDefault();
	const results = await provider.search({ query: input.value });
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

  marker.on('dragend', function(event) {
    var position = marker.getLatLng();
    marker.setLatLng(position, {
      draggable: 'true'
    }).bindPopup(position).update();
    $("#inputLatitudine").val(position.lat);
    $("#inputLongitudine").val(position.lng).keyup();
  });

  $("#inputLatitudine, #inputLongitudine").change(function() {
    var position = [parseInt($("#inputLatitudine").val()), parseInt($("#inputLongitudine").val())];
    marker.setLatLng(position, {
      draggable: 'true'
    }).bindPopup(position).update();
    map.panTo(position);
  });
  map.addLayer(marker);
})
</script>
@stop
