<div class="row" style="margin-bottom: 20px">
  <div class="col-md-4">
    <label for="paciente_id">Paciente</label>
    <div class="input-group ">
      <input placeholder="Ingresar Nombre o Cédula" name="paciente_id" type="text" id="buscar-paciente" class="form-control" value="{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido . '. CI:' . $analisis->paciente->cedula}}">
      <input type="hidden" name="paciente_id" id="paciente_id" value="{{$analisis->paciente->id}}">
      <span class="input-group-btn">
        <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addPaciente" style="height:34px">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>
</div>
<div class="row" id="paciente-box">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Paciente</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Nombre y Apellido</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="full-name-to-show" class="form-control" value="{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Cédula</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="ci-to-show" class="form-control" value="{{$analisis->paciente->cedula_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Sexo</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="sexo-to-show" class="form-control" value="{{$analisis->paciente->sexo_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Fecha de Nacimiento</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="fecha-nacimiento-to-show" class="form-control" value="{{$analisis->paciente->fecha_nacimiento_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Edad</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="edad-to-show" class="form-control" value="{{$analisis->paciente->edad}}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Análisis</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="data-table table table-bordered table-hover" id="analisisTable">
            <thead>
              <tr>
                <th>Determinación</th>
                <th>Valor</th>
                <th>Rango Referencia</th>
                <th>Fuera de rango</th>
                <th>Acción</th>
              </tr>
            </thead>
            @php
              $subseccion_actual = -1;
            @endphp
            <tbody id="analisisBody">
              @foreach ($analisis->resultados as $resultado)
                @if($subseccion_actual != $resultado->determinacion->subseccion->id)
                  <tr class='tr-titulo'>
                    <td colspan='4' style='text-align:center'>
                      <u>{{$resultado->determinacion->subseccion->titulo}}</u>
                    </td>
                    <td>
                      <button subId='{{$resultado->determinacion->subseccion->id}}' type='button' class='btn btn-danger btn-flat delete-sub'>
                        <i class='fa fa-trash'></i>
                      </button>
                    </td>
                  </tr>
                @endif
                <tr class='determinacion-{{$resultado->determinacion->subseccion->id}}'>
                   <td>{{$resultado->determinacion->titulo}}</td>
                   @switch ($resultado->determinacion->tipo_referencia)
                     @case ("booleano")
                       <td>
                          <select class='form-control determinacion-select valor' name=determinacion[{{$resultado->determinacion->id}}]>
                            <option @if($resultado->valor == 'Negativo') selected @endif value='Negativo'>Negativo</option>
                            <option @if($resultado->valor == 'Positivo') selected @endif value='Positivo'>Positivo</option>
                          </select>
                        </td>
                       @break
                     @case ('reactiva')
                        <td>
                          <select class='form-control valor' name=determinacion[{{$resultado->determinacion->id}}]>
                              <option @if($resultado->valor == 'No Reactiva') selected @endif value='No Reactiva'>No Reactiva</option>
                              <option @if($resultado->valor == 'Reactiva') selected @endif value='Reactiva'>Reactiva</option>
                          </select>
                        </td>
                       @break;
                     @case ('rango')
                       <td><input class='form-control determinacion-rango valor' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                       @break
                     @case ('rango_edad')
                       <td><input class='form-control determinacion-rango-edad valor' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                       @break
                     @case ('rango_sexo')
                       <td><input class='form-control determinacion-rango-sexo valor' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                       @break
                     @default
                       <td><input class='form-control valor' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                  @endswitch
                  <td>
                     {{$resultado->determinacion->rango_referencia_format}}
                     <input type='hidden' class='rango-referencia' value='{{$resultado->determinacion->rango_referencia}}'>
                  </td>
                  <td class='center'>
                    @if($resultado->determinacion->tipo_referencia != 'sin_referencia')
                      <input type='checkbox' class='rango-check flat-blue' id='check-{{$resultado->determinacion->id}}' name=fuera_rango[{{$resultado->determinacion->id}}] @if($resultado->fuera_rango) checked @endif>
                    @endif
                  </td>
                  <td>
                      <button subId="{{$resultado->determinacion->subseccion->id}}" type='button' class='btn btn-danger btn-flat delete-det'>
                        <i class='fa fa-trash'></i>
                      </button>
                  </td>
                </tr>
                @php
                  $subseccion_actual = $resultado->determinacion->subseccion->id;
                @endphp
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
