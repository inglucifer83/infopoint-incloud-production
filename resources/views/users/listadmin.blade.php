@extends('templates.layout')
@section('title')
Lista Utenti
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
                <h1 class="text-primary">Elenco Utenti</h1>
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
                <a href="{{ route('users.create') }}"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> Aggiungi Utente</button></a>
             </div>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                <table id="individual-col-search" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Infopoint</th>
                            <th>Comune</th>
                            <th>Ruolo</th>
                            <th>Numero Cellulare</th>
                            <th>Email</th>
                            <th class="text-center dt-no-sorting">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $users as $user)
                        <tr class="user-item">
                            <td>{{ $user->name }}</td>
                            <td>{{ $infopoint->find($user->infopoint_id, "id")->denominazione ?? '' }}</td>
                            <td>{{ $user->getUserComuneName($user->id) ?? '' }}</td>
                            <td>{{ $role->find($user->role_id, "id")->descrizione }}</td>
                            <td>{{ $user->cellulare }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifica"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                @if($user->id !== Auth::user()->id)
                                    <a href="{{ route('users.destroy', $user->id) }}" class="bs-tooltip delete-user-a" data-toggle="tooltip" data-placement="top" title="" data-original-title="Elimina"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Infopoint</th>
                            <th>Comune</th>
                            <th>Ruolo</th>
                            <th>Numero Cellulare</th>
                            <th>Email</th>
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

              $('.delete-user-a').on('click', function(ele){
                  ele.preventDefault();
                  var urlApp = $(this).attr('href');
                  var tr = $(this).parents('.user-item');
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

@stop
