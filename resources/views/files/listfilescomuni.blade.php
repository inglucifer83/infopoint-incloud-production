@extends('templates.layout')
@section('title')
Lista Files Comuni
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="/assets/css/forms/theme-checkbox-radio.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" type="text/css" href="/plugins/table/datatable/custom_dt_custom.css">
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
                <h1 class="text-primary">AGGIUNGI FILE AL COMUNE</h1>
                <h2 class="text-primary">{{ $comuni->nomecomune }}</h2>
            </div>
        </div>         
            <div class="row layout-spacing mt-4">
                <div class="col-lg-12">
                    <h2 class="text-center">Lista files per il Comune: {{ $comuni->nomecomune }}</h2>
                    <h5 class="text-center mb-3">E' possibile caricare i file visibili solo al supervisor degli
                        Infopoint</h5>
                    <button class='btn btn-primary btn-block mb-4 mr-2' data-toggle="modal"
                        data-target="#modalAddFile"><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24'
                            viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'
                            stroke-linecap='round' stroke-linejoin='round' class='feather feather-cloud-rain'>
                            <line x1='16' y1='13' x2='16' y2='21'></line>
                            <line x1='8' y1='13' x2='8' y2='21'></line>
                            <line x1='12' y1='15' x2='12' y2='23'></line>
                            <path d='M20 16.58A5 5 0 0 0 18 7h-1.26A8 8 0 1 0 4 15.25'></path>
                        </svg> AGGIUNGI I FILE</button>
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div id="style-3_wrapper"
                                class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="style-3" class="table style-3 table-hover dataTable no-footer" role="grid"
                                aria-describedby="style-3_info">
                                <thead>
                                    <tr role="row">
                                        <th class="checkbox-column text-center sorting_asc" tabindex="0"
                                            aria-controls="style-3" rowspan="1" colspan="1" style="width: 70px;"
                                            aria-sort="ascending"
                                            aria-label=" Record Id : cliccare per ordinare la colonna in modo discendente">
                                            Id File</th>
                                        <th class="sorting" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1"
                                            style="width: 180px;"
                                            aria-label="Nome File: cliccare per ordinare la colonna in modo ascendente">
                                            Nome File</th>
                                        <th class="sorting" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1"
                                            style="width: 90px;"
                                            aria-label="Estensione: cliccare per ordinare la colonna in modo ascendente">
                                            Estensione File</th>
                                        <th class="sorting" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1"
                                            style="width: 300px;"
                                            aria-label="Descrizione: cliccare per ordinare la colonna in modo ascendente">
                                            Descrizione File</th>
                                        <th class="text-center sorting" tabindex="0" aria-controls="style-3" rowspan="1"
                                            colspan="1" style="width: 90px;"
                                            aria-label="Gruppo File: cliccare per ordinare la colonna in modo ascendente">
                                            Gruppo File</th>
                                        <th class="text-center dt-no-sorting sorting" tabindex="0"
                                            aria-controls="style-3" rowspan="1" colspan="1" style="width: 110px;"
                                            aria-label="Azioni: cliccare per ordinare la colonna in modo ascendente">
                                            Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="files-item">
                                        @foreach ($filescomuni as $filecomune)
                                        <td class="checkbox-column text-center sorting_1">{{ $filecomune->id }}</td>
                                        <td>{{ $filecomune->nomeFile }}</td>
                                        <td>{{ $filecomune->estensioneFile }}</td>
                                        <td>{{ $filecomune->descrizioneFile }}</td>
                                        <td class="text-center"><span
                                                class="shadow-none badge" style="color:#fff; background-color: #{{ $gruppofiles->find($filecomune->gruppo_id, "id")->codcolore }}">{{ $gruppofiles->find($filecomune->gruppo_id, "id")->descrizione }}</span></td>
                                        <td class="text-center">
                                            <ul class="table-controls">
                                                <li><a href="" class="editbtn"
                                                        data-toggle="modal" data-target="#modalModFile" data-placement="top" title=""
                                                        data-original-title="Modifica"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-edit-2 p-1 br-6 mb-1">
                                                            <path
                                                                d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                            </path>
                                                        </svg></a></li>
                                                <li><a href="{{ asset($filecomune->pathcomunefiles) }}" target="_new" class="bs-tooltip"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Visualizza"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-eye">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                            </path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg></a></li>
                                                <li><a href="{{ asset($filecomune->pathcomunefiles) }}" download rel="noopener noreferrer" target="_blank"  class="bs-tooltip"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Scarica"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevrons-down">
                                                            <polyline points="7 13 12 18 17 13"></polyline>
                                                            <polyline points="7 6 12 11 17 6"></polyline>
                                                        </svg></a></li>
                                                <li><a href="{{  route('filescomuni.destroy', $filecomune->id) }}" class="bs-tooltip delete-file-a"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Cancella"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trash p-1 br-6 mb-1">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                        </svg></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
     <!-- Modal Aggiunta File-->
     <div class="modal fade" id="modalAddFile" tabindex="-1" role="dialog" aria-labelledby="modalAddFileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalAddFileLabel">Aggiungi File</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 </button>
             </div>
             <div class="modal-body">
                 <form id="modalAddFileForm" action="{{ route('filescomuni.store') }}" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="comune_id" value="{{ $comuni->id }}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="form-row">
                         <div class="col-md-12 mb-4">
                             <label for="descrizioneFile">Descrizione Contenuto File</label>
                             <textarea type="text" class="form-control" name="descrizioneFile" id="descrizioneFile"
                                 placeholder="Inserisci una descrizione del contenuto del file" rows="3"></textarea>
                         </div>
                     </div>
                     <div class="form-row">
                         <div class="col-md-12 mb-4">
                             <label for="gruppoFile">Gruppo File</label>
                             <select id="gruppoFile" name="gruppoFile" class="form-control">
                                 <option value="" selected>Seleziona...</option>
                                 @foreach ($gruppofiles as $gruppofile)
                                     <option value="{{ $gruppofile->id }}">{{ $gruppofile->descrizione }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="form-row">
                         <div class="col-md-6">
                             <label for="caricaFileComune">Carica il file</label>
                             <input type="file" name="caricaFileComune" class="form-control-file" id="caricaFileComune">
                         </div>

                     </div>
                     <div class="modal-footer">
                         <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Annulla</button>
                         <button type="submit" class="btn btn-primary">Salva</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Modifica File-->
 <div class="modal fade" id="modalModFile" tabindex="-1" role="dialog" aria-labelledby="modalModFileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="modalModFileLabel">Modifica File</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             </button>
         </div>
         <div class="modal-body">
            @isset($filecomune->id)
             <form id="modalModFileForm" enctype="multipart/form-data">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 {{ method_field('PUT') }}
                 <input type="hidden" name="id-file" id="id-file" value="{{ $filecomune->id }}">
                 <input type="hidden" name="id-gruppo" id="id-gruppo" value="{{ $filecomune->gruppo_id }}">
                 <input type="hidden" name="id-accesso" id="id-accesso" value="{{ $filecomune->gruppo_id }}">
                 <div class="form-row">
                     <div class="col-md-12 mb-4">
                         <label for="descrizioneFileMod">Descrizione Contenuto File</label>
                         <textarea type="text" class="form-control" name="descrizioneFileMod" id="descrizioneFileMod"
                             placeholder="Inserisci una descrizione del contenuto del file" rows="3">{{ $filecomune->descrizioneFile?$filecomune->descrizioneFile:'' }}</textarea>
                     </div>
                 </div>
                 <div class="form-row">
                     <div class="col-md-12 mb-4">
                         <label for="gruppoFileMod">Gruppo File</label>
                         <select id="gruppoFileMod" name="gruppoFileMod" class="form-control">
                             <option value="" selected>Seleziona...</option>
                             @foreach ($gruppofiles as $gruppofile)
                                 <option value="{{ $gruppofile->id }}" {{ $gruppofile->id == $filecomune->gruppo_id ? 'selected' : '' }}>{{ $gruppofile->descrizione }}</option>
                             @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Annulla</button>
                     <button type="submit" class="btn btn-primary">Salva</button>
                 </div>
             </form>
             @endisset
         </div>
     </div>
 </div>
</div>
    @component('components.footer')
    @endcomponent
</div>
@stop
@section('page-script')
<script src="/assets/js/custom.js"></script>
<script src="/plugins/table/datatable/datatables.js"></script>
<script>
    //MODIFICA
    $(document).ready(function(){
        $('.editbtn').on('click', function(){
            $('#modalModFile').modal('show');
            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);
            $('#id-file').val(data[0]);
            $('#descrizioneFileMod').val(data[3]);
        });
        $('#modalModFileForm').on('submit', function(e){
            e.preventDefault();

            var id = $('#id-file').val();

            $.ajax({
                type: "PUT",
                url:"/filescomuni/"+id,
                data: $('#modalModFileForm').serialize(),
                success: function(response){
                    console.log(response);
                    $('#modalModFile').modal('hide');

                    window.location.reload();
                },
                error: function(error){
                    console.log(error);
                    alert("Salvataggio non riuscito");
                }
            })
        });
    });
</script>
<script>
    c3 = $('#style-3').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Visualizza _PAGE_ di _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Cerca...",
            "sLengthMenu": "Risultati :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [5, 10, 20, 50],
        "pageLength": 5
    });
    multiCheck(c3);
</script>
<script>
    $('document').ready(function(){
              $('div.alert').fadeOut(3000);

              $('.delete-file-a').on('click', function(ele){
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

@stop


