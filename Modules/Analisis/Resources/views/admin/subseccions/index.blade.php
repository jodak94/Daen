@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('analisis::subseccions.title.subseccions') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('analisis::subseccions.title.subseccions') }}</li>
    </ol>
@stop
@push('css-stack')
  <link rel="stylesheet" href="{{ asset('themes/adminlte/css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') }}">
  <style>
    .orden-td{
      text-align: center;
    }
    .orden-td:hover{
      cursor: move;
    }
    .orden-td:active{
      cursor: move;
    }
    .btn{
      height: 34px;
    }
  </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.analisis.subseccion.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('analisis::subseccions.button.create subseccion') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Sección</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($subseccions)): ?>
                            <?php foreach ($subseccions as $subseccion): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.analisis.subseccion.edit', [$subseccion->id]) }}">
                                        {{ $subseccion->titulo }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.analisis.subseccion.edit', [$subseccion->id]) }}">
                                        {{ $subseccion->seccion->titulo }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="ordenar-determinaciones btn btn-default btn-flat" subseccion="{{$subseccion->id}}">Ordenar Determinaciones</button>
                                        <a href="{{ route('admin.analisis.subseccion.edit', [$subseccion->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.analisis.subseccion.destroy', [$subseccion->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Título</th>
                                <th>Sección</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('analisis::subseccions.title.create subseccion') }}</dd>
    </dl>
@stop

@include('analisis::admin.subseccions.partials.modal-ordenar-determinaciones')
@push('js-stack')
    <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
    @include('analisis::admin.subseccions.partials.script-index')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.analisis.subseccion.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "pageLength": 50,
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
