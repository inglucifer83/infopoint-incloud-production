@extends('templates.layout')
@section('title')
Lista Strutture Ricettive
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/custom_dt_miscellaneous.css">
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
                <h1 class="text-primary">Elenco Strutture Ricettive</h1>
            </div>
        </div>
        <div class="row mt-4">
            @if(!Auth::user()->isAdmin())
                <div class="col-xl-4 col-lg-6 col-sm-6 layout-spacing d-flex justify-content-center">
                    <a href="{{ route('strutturericettive.create') }}?comune_id={{ Auth::user()->getUserInfopointId() }}"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sunrise"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="2" x2="12" y2="9"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="8 6 12 2 16 6"></polyline></svg> Aggiungi Struttura Ricettiva</button></a>
                </div>
            @endif
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                <table id="individual-col-search" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Denominazione</th>
                            <th>Comune</th>
                            <th>Frazione</th>
                            <th>Indirizzo</th>
                            <th>Tipologia</th>
                            <th>Mappa</th>
                            <th class="text-center dt-no-sorting">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $strutturericettive as $struttura)
                        <tr class="struttura-item">
                            <td>{{ $struttura->denominazione }}</td>
                            <td>{{ $comuni->find($struttura->comune_id, "id")->nomecomune }}</td>
                            <td>{{ $struttura->frazione }}</td>
                            <td>{{ $struttura->indirizzo }}</td>
                            <td>{{ $tipostrutturaricettiva->find($struttura->tipostrutturaricettiva_id, "id")->descrizione }}</td>
                            <td><a href="{{ $struttura->urlmappa }}" target="_new" alt="Mappa">Link</a></td>
                            <td class="text-center">
                                <a href="{{ route('strutturericettive.show', $struttura->id) }}" target="_parent" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Apri"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                @if(Auth::user()->isAdmin() || Auth::user()->getUserInfopointId() === $struttura->comune_id)
                                    <a href="{{ route('strutturericettive.edit', $struttura->id) }}" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifica"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                @endif
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Condividi"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cloud-snow"><path d="M20 17.58A5 5 0 0 0 18 8h-1.26A8 8 0 1 0 4 16.25"></path><line x1="8" y1="16" x2="8.01" y2="16"></line><line x1="8" y1="20" x2="8.01" y2="20"></line><line x1="12" y1="18" x2="12.01" y2="18"></line><line x1="12" y1="22" x2="12.01" y2="22"></line><line x1="16" y1="16" x2="16.01" y2="16"></line><line x1="16" y1="20" x2="16.01" y2="20"></line></svg></a>
                                @if(Auth::user()->isAdmin() || Auth::user()->getUserInfopointId() === $struttura->comune_id)
                                    <a href="{{ route('strutturericettive.destroy', $struttura->id) }}" class="bs-tooltip delete-strutture-a" data-toggle="tooltip" data-placement="top" title="" data-original-title="Elimina"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Donominazione</th>
                            <th>Comune</th>
                            <th>Frazione</th>
                            <th>Indirizzo</th>
                            <th>Tipologia</th>
                            <th class="invisible">Mappa</th>
                            <th class="invisible">Azioni</th>
                        </tr>
                    </tfoot>
                </table>
                    </div>
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
<script src="/plugins/table/datatable/custom_miscellaneous.js"></script>

<script>
    $('document').ready(function(){
              $('div.alert').fadeOut(3000);

              $('.delete-strutture-a').on('click', function(ele){
                  ele.preventDefault();
                  var urlApp = $(this).attr('href');
                  var tr = $(this).parents('.struttura-item');
                  if (confirm('Sei sicuro di voler cancellare questa Struttura ?')) {
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

@stop

