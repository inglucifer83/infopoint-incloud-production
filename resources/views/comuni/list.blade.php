@extends('templates.layout')
@section('title')
Lista Comuni
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
<link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css">
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
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <h1 class="text-primary">COMUNI</h1>
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                <a href="comuni/create"><button class="btn btn-success mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Aggiungi</button></a>
            </div>
        </div>
        <div class="row layout-top-spacing" id="cancel-row">          
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donominazione</th>
                                <th>Indirizzo</th>
                                <th>Responsabile</th>
                                <th>Info</th>
                                <th>Mappa</th>
                                <th>Avatar</th>
                                <th class="dt-no-sorting">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comuni as $comune)
                                <tr class="comune-item">
                                    <td>{{ $comune->id }}</td>
                                    <td>{{ $comune->nomecomune }}</td>
                                    <td>{{ $comune->indirizzo }}</td>
                                    <td>{{ $comune->responsabile }}</td>
                                    <td><a href="{{ $comune->urlext }}" target="_new">Link Info</a></td>
                                    <td><a href="{{ $comune->urlmappa }}" target="_new">Link Mappa</a></td>
                                    <td>
                                        <div class="d-flex">
                                            @if($comune->pathImage)
                                                <div class="usr-img-frame mr-2 rounded-circle">
                                                    <img alt="avatar" class="img-fluid rounded-circle" src="{{ asset($comune->pathcomunelogo) }}">
                                                </div>
                                            @else
                                                <div class="avatar avatar-sm">
                                                    <span class="avatar-title rounded-circle">{{ $comune->nomecomune[0].Str::upper($comune->nomecomune[3]) }}</span>
                                                </div>    
                                            @endif    
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/comuni/{{ $comune->id }}/edit"><button type="button" class="btn btn-dark btn-sm btn-link">Apri</button></a>
                                            <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                <a class="dropdown-item" href="/comuni/{{ $comune->id }}/filescomuni">Gestione File</a>
                                                <a class="dropdown-item" href="/comuni/{{ $comune->id }}/infopoint">Gestione Infopoint</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete-comune-a" href="{{ route('comuni.destroy', $comune->id) }}">Elimina</a>
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

              $('.delete-comune-a').on('click', function(ele){
                  ele.preventDefault();
                  var urlApp = $(this).attr('href');
                  var tr = $(this).parents('.comune-item');
                  if (confirm('Sei sicuro di voler cancellare questo conferimento ?')) {
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
<!-- END PAGE LEVEL CUSTOM SCRIPTS -->
@stop

