<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struttura Ricettiva: {{ $strutturericettive->denominazione }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/pdf.css" />
    <link rel="stylesheet" href="/assets/css/pdfluogo.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/assets/js/pdf.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</head>
<body>
<div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row">
        <div class="col-md-12 text-right mb-3">
            <button class="btn btn-primary" id="download"> Scarica PDF</button>
        </div>
        <div class="col-md-12">
            <div class="card" id="invoice">
                <div class="card-header bg-transparent header-elements-inline">
                    <img height="90px" src="/img/logo-infopoint.png" alt="Logo Infopointcilento in cloud">
                    <h6 class="card-title text-primary">Stampa Luogo Interesse</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-4 pull-left">
                                <ul class="list list-unstyled mb-0 text-left">
                                    <img src="{{ asset($strutturericettive->pathluoghiinteresse) }}" alt="Foto Struttura Ricettiva" style="height: 180px">
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-4 ">
                                <div class="text-sm-right">
                                    <h4 class="invoice-color mb-2 mt-md-2">{{ $strutturericettive->denominazione }}</h4>
                                    <ul class="list list-unstyled mb-0">
                                        <li>Comune: <span class="font-weight-semibold">{{ $comuni->nomecomune }}</span></li>
                                        <li>Frazione: <span class="font-weight-semibold">{{ $strutturericettive->frazione }}</span></li>
                                        <li>INDIRIZZO:</li>
                                        <p>{{ $strutturericettive->indirizzo  }}</p>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Email</h5>
                            <p>{{ $strutturericettive->email }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Sito Web</h5>
                            <p>{{ $strutturericettive->website }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Telefono</h5>
                            <p>{{ $strutturericettive->telefono }}</p>
                        </div>
                    </div>
                    <hr>
                    @if(count($aperturestrutturericettive) > 0)
                        <h4 class="ml-2">Orari di Apertura</h4>
                        <div class="row px-4">
                        @foreach($aperturestrutturericettive as $key => $orari)
                            <div class="col-md-2 mt-2 text-center border">
                                <h6>{{ $giornisettimana->find($orari->giornosettimana_id, "id")->giorno }}</h6>
                                <p>{{date('G:i', strtotime($orari->orario_apertura))}} - {{date('G:i', strtotime($orari->orario_chiusura))}}</p>
                            </div>
                        @endforeach
                        </div>
                    @endif
                <div class="row py-2 notediv">
                    <p class="mx-4">NOTE: <br> {{ $strutturericettive->note }}</p>
                </div>
                @if($strutturericettive->descrizione)
                    <div class="container border border-info">
                        <h2 class="my-3">Descrizione:</h2>
                        <hr>
                        {!! $strutturericettive->descrizione !!}
                    </div>
                @endif
                <div class="row py-3">
                    @foreach($fotostrutturericettive as $fotostruttura)
                        <div class="ph-item col-md-4 mt-2">
                            <div class="card component-card_2">
                                <img src="{{ asset($fotostruttura->pathfotoluoghi) }}" class="card-img-top" alt="widget-card-2">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="container">
                    <div class="row mt-4 justify-content-center align-items-center">
                        @if($strutturericettive->urlmappa)
                            <div class="col-md-4">
                                <div class="mb-4 text-center">
                                    <a href="{{ $strutturericettive->urlmappa }}" target="_parent"><h6>Mappa - Link</h6></a>
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate("$strutturericettive->urlmappa")) !!} ">
                                    <p>Scansiona il qr-code per visualizzare la mappa.</p>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="mb-4 text-center">
                                @if($strutturericettive->pathFile)
                                    <h4>Visualizza File Correlato</h4>
                                    <a href="{{ asset($strutturericettive->pathfileluoghiinteresse) }}" target="_new" ><img src="/img/icons/file-download.png"
                                    alt="File Principale" style="height: 130px"></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><img src="/img/logo-cilentomania.png" alt="Cilentomania"> Realizzato da Cristian Pinto - Tutti i diritti riservati</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>