@extends('layouts.master')

@section('content-header')

@stop
@push('css-stack')
  <link rel="stylesheet" href="{{ asset('themes/adminlte/css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') }}">
  <style>
    .input-error{
      background-color: #d73925;
      color: #fff;
    }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{
      border: 1px solid #ddd
    }
    .center{
      text-align: center;
    }
    .tr-titulo{
      background-color: #efefef;
    }
    .picker__select--year{
      padding: 1px;
    }
    .picker__select--month{
      padding: 1px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
      background-color: #3c8dbc;
      border: 1px solid #3c8dbc;
    }

  </style>
@endpush
@section('content')
    {!! Form::open(['route' => ['admin.analisis.analisis.post_generate_informe'], 'method' => 'post', 'id' => 'analisis-form', 'files' => true]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            <div class="box-header" style="border-bottom: 1px solid #f4f4f4">
                              <h3 style="margin:0">
                                  Generar Informe
                              </h3>
                            </div>
                            <div class="box-body">
                              <div class="col-md-6">
                                <div class="form-group">
                                  {!! Form::label('image','Imagen')!!}
                                  <input id="img-input" type="file" class="form-control">
                                  <div id="inputs-container" style='display:none'>

                                  </div>

                                </div>
                              </div>
                              <div class='col-md-6'>
                                {!! Form::normalInput('analisis_id', 'Analisis id', $errors) !!}
                              </div>
                              <div class="col-md-12" id="img-container">

                              </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.analisis.analisis.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop
@include('pacientes::admin.pacientes.partials.modal-add-paciente')
@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
  <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
  @include('analisis::admin.analises.partials.script-informe')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.analisis.analisis.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
