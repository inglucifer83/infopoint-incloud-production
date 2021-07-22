@extends('templates.layout')
@section('title')
@if($user->id)
    Modifica Utente: {{ $user->name }}
@else
    Nuovo Utente
@endif
@endsection
@section('page-style')
    <link rel="stylesheet" type="text/css" href="/assets/css/elements/alert.css">
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css"/>
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
                <div class="form-group col-md-12">
                    @if($user->pathImage)
                    <img class="rounded" style="max-height: 150px" src="{{ asset($user->pathavatar) }}" alt="Foto Utente">
                    @endif
                </div>
            </div>
        <div class="row mt-4 mb-5">
            <div class="col-xl-6 col-lg-6 col-sm-6">
                @if($user->id)
                    <h1 class="text-primary title-infopoint">Modifica Utente: {{ $user->name }}</h1>
                @else
                    <h1 class="text-primary title-infopoint">Nuovo Utente</h1>
                @endif   
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6 text-center">
               <a href="/users"><button class="btn btn-info mb-2 mr-2 btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg> Lista Utenti</button></a>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            @if($user->id)
                <form class="form-input" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
            @else
                <form class="form-input" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
            @endif
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <label for="inputName">Nome e Cognome*</label>
                        <input type="text" class="form-control" name="inputName" id="inputName" value="{{ $user->name?$user->name: old('name') }}">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label for="inputEmail">Email*</label>
                      <input type="text" class="form-control" name="inputEmail" id="inputEmail" maxlength="60" value="{{ $user->email?$user->email: old('email') }}">
                  </div>
                </div>
                    <div class="form-row">
                        @if(!$user->id)
                            <div class="col-md-4 mb-4">
                                <label for="password">Password*</label>
                                <input type="password" class="form-control" name="password" maxlength="120" id="password" value="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="password_confirmation">Conferma Password*</label>
                                <input type="password" class="form-control" name="password_confirmation" maxlength="120" id="password_confirmation" value="">
                            </div>
                        @else
                        <div class="col-md-2 mb-4 my-auto">
                            <button type="button" data-toggle="modal" data-target="#editPassword" class="btn btn-warning mb-2 mr-2 btn-rounded">Reset Password <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg></button>
                        </div>
                        @endif
                        <div class="col-md-4 mb-4">
                            <label for="inputCellulare">Cellulare</label>
                            <input type="text" class="form-control" maxlength="30" name="inputCellulare" id="inputCellulare" value="{{ $user->cellulare?$user->cellulare:'' }}">
                        </div>
                    </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="caricaImg">Immagine Utente</label>
                        <input type="file" name="caricaImg" class="form-control-file" id="caricaImg">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="tipoRuolo">Ruolo Utente*</label>
                        <select id="tipoRuolo" name="tipoRuolo" class="form-control">
                            <option value="" selected>Seleziona...</option>
                            @foreach ($role as $rol)
                                <option
                                    value="{{ $rol->id }}" {{ $rol->id == $user->role_id ? 'selected' : '' }}>{{ $rol->descrizione }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="infopoint">Infopoint</label>
                        <select id="infopoint" name="infopoint" class="form-control">
                            <option value="" selected>Seleziona...</option>
                            @foreach ($infopoint as $info)
                                <option
                                    value="{{ $info->id }}" {{ $info->id == $user->infopoint_id ? 'selected' : '' }}>{{ $info->denominazione }} - {{ $comuni->find($info->comune_id, "comune_id")->nomecomune ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="userid" id="userid" value="{{ $user->id }}">
              <button class="btn btn-primary mt-3" type="submit">Salva</button>
            </form>
        </div>
        @if($user->id)
        <div class="row layout-spacing mt-4">
            <div class="col-lg-12">
                <h2 class="text-center">Lingue Parlate</h2>
                <a href="" class='addbtn btn btn-primary btn-block mb-4 mr-2' data-toggle="modal"
                   data-placement="top" title="" data-original-title="Aggiungi" data-target="#modalAddLingua">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-clock">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Aggiungi Lingua
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
                                    aria-label="Lingua Parlata: cliccare per ordinare la colonna in modo ascendente">
                                    Lingua Parlata
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
                            <tbody id="tbllingua">
                            @foreach ($lingueuser as $linguauser)
                            <tr role="row" class="files-item">
                                    <td>{{ $lingue->find($linguauser->lingua_id, "id")->lingua }}</td>
                                    <td class="text-center">
                                                <a href="{{ route('lingueusers.destroy', $linguauser->id)  }}"
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
        <!-- Modal Aggiunta File-->
        <div class="modal fade" id="modalAddLingua" tabindex="-1" role="dialog"
        aria-labelledby="modalAddLinguaLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content"> 
               <div class="modal-header">
                   <h5 class="modal-title" id="modalAddLinguaLabel">Aggiungi Lingua</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   </button>
               </div>
               <div class="modal-body">
                   <form id="modalAddLinguaForm" method="POST" enctype="multipart/form-data">
                       <input type="hidden" name="user_id" value="{{ $user->id }}">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <div class="form-row">
                           <div class="col-md-12 mb-4">
                               <label for="linguaParlata">Lingua Parlata</label>
                               <select id="linguaParlata" name="linguaParlata" class="form-control" required>
                                   <option value="" selected>Seleziona...</option>
                                   @foreach ($lingue as $lingua)
                                       <option
                                           value="{{ $lingua->id }}">{{ $lingua->lingua }}</option>
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
    @component('components.footer')
    @endcomponent
</div>
@stop
@section('page-script')
<script>
    //AGGIUNGI
    $(document).ready(function(){
        $('.addbtn').on('click', function(){
            $('#modalAddLingua').modal('show');
        });
        $('#modalAddLinguaForm').on('submit', function(e){
            e.preventDefault();
            var lingua = $('#linguaParlata').children(':selected').text();
            $.ajax({
                type: "POST",
                url:"/lingueusers",
                data: $('#modalAddLinguaForm').serialize(),
                success: function(response){
                    var formLingua = $('#tbllingua');
                    formLingua.append('<tr role="row" class="files-item"><td>'+lingua+'</td><td class="text-center"></td></tr>');
                    $('#modalAddLingua').modal('hide');
                },
                error: function(error){
                    console.log(error);
                    alert('Salvataggio non riuscito');
                }

            })
            console.log($('#modalAddLinguaForm').serialize());
        });
    });
</script>
<script>
    $('document').ready(function(){
        $('.delete-orario-a').on('click', function(ele){
            ele.preventDefault();
            var urlApp = $(this).attr('href');
            var tr = $(this).parents('.files-item');
            if (confirm('Sei sicuro di voler cancellare questa Lingua ?')) {
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
@stop
