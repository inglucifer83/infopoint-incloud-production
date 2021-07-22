@extends('templates.layout')
@section('title')
Dashboard UTENTE
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="/assets/css/widgets/modules-widgets.css">
<style>
    .widget-table-two .table {
        border-spacing: revert!important;
}
    .item-timeline svg {
        color: #000000!important;
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
            <h1 class="text-secondary mb-5">Dashboard</h1>
            <div class="row">
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">
                        <div class="widget-heading">
                            <h5 class="text-primary">Cosa fare oggi a: {{ Str::upper($comuni->find(Auth::user()->getUserInfopointId(), "id")->nomecomune) }}</h5>
                        </div>
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><div class="th-content">Data Inizio</div></th>
                                            <th><div class="th-content">Data Fine</div></th>
                                            <th><div class="th-content">Denominazione</div></th>
                                            <th><div class="th-content">Tipologia</div></th>
                                            <th><div class="th-content">Azioni</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eventicomune as $eventocomune)
                                            <tr>
                                                <td><div class="td-content">{!! date("d-m-Y", strtotime($eventocomune->inizio_evento))  !!}</div></td>
                                                <td><div class="td-content">{!! date("d-m-Y", strtotime($eventocomune->fine_evento))  !!}</div></td>
                                                <td><div class="td-content">{{ Str::words($eventocomune->denominazione, 9, ' ...') }}</div></td>
                                                <td><div class="td-content"><span class="">{{ $tipoeventi->find($eventocomune->tipoeventi_id, "id")->descrizione }}</span></div></td>
                                                <td><a href="{{ route('eventi.show', $eventocomune->id) }}"><div class="td-content"><span class="badge badge-success">APRI</span></div></a></td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-activity-five">
                        <div class="widget-heading">
                            <h5 class="text-primary">Ultime News</h5>
                            <div class="task-action">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                        <a class="dropdown-item" href="/news">Vai alla Sezione</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div class="w-shadow-top"></div>
                            <div class="mt-container mx-auto ps ps--active-y">
                                <div class="timeline-line">
                                    @foreach ($news as $new)
                                        <div class="item-timeline timeline-new">
                                            <div class="t-dot" data-original-title="" title="">
                                                <div style="background-color:#{!! $tiponews->find($new->tiponews_id, "id")->colore !!}">{!! $tiponews->find($new->tiponews_id, "id")->icona !!}</div>
                                            </div>
                                            <a href="{{ route('news.show', $new->id) }}"><div class="t-content">
                                                <div class="t-uppercontent">
                                                    <h5>{{ Str::words($new->descrizione, 6, ' ...') }}</span></h5>
                                                </div>
                                                <p>{{ $new->updated_at->format('d/m/Y G:i:s') }} - {{ $tiponews->find($new->tiponews_id, "id")->descrizione }}</p>
                                            </div>
                                        </a>
                                        </div>  
                                    @endforeach                                   
                                </div>                                    
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 332px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 237px;"></div></div></div>
                            <div class="w-shadow-bottom"></div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">
                        <div class="widget-heading">
                            <h5 class="text-primary">Cosa fare oggi nel CILENTO</h5>
                        </div>
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><div class="th-content">Data Inizio</div></th>
                                            <th><div class="th-content">Data Fine</div></th>
                                            <th><div class="th-content">Denominazione</div></th>
                                            <th><div class="th-content">Comune</div></th>
                                            <th><div class="th-content">Tipologia</div></th>
                                            <th><div class="th-content">Azioni</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eventi as $evento)
                                            <tr>
                                                <td><div class="td-content">{!! date("d-m-Y", strtotime($evento->inizio_evento))  !!}</div></td>
                                                <td><div class="td-content">{!! date("d-m-Y", strtotime($evento->fine_evento))  !!}</div></td>
                                                <td><div class="td-content">{{ Str::words($evento->denominazione, 6, ' ...') }}</div></td>
                                                <td><div class="td-content">{{ $comuni->find($evento->comune_id, "id")->nomecomune }}</div></td>
                                                <td><div class="td-content"><span class="">{{ $tipoeventi->find($evento->tipoeventi_id, "id")->descrizione }}</span></div></td>
                                                <td><a href="{{ route('eventi.show', $evento->id) }}"><div class="td-content"><span class="badge badge-success">APRI</span></div></a></td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
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
<script src="/assets/js/widgets/modules-widgets.js"></script>
@stop
