<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Plantilla</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            {!! Form::normalInput('nombre', 'Nombre de Plantilla', $errors, null, ['required' => true]) !!}
          </div>
          <div class='col-md-3'><span style='color:white'>*</span>
            {!! Form:: normalCheckbox('last_name_first', 'Apellido primero al imprimir', $errors) !!}
          </div>
          <div class="col-md-2">
            {!! Form::normalInput('precio', 'Precio (Gs.)', $errors, null, ['class' => 'form-control number_format_2']) !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null) !!}
          </div>
          <div class="col-md-4">
            {!! Form::normalInput('buscar-seccion', 'Agregar Grupo', $errors, null) !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-9">
            <table class="data-table table table-bordered table-hover" id="analisisTable">
              <thead>
                <tr>
                  <th>Determinación</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody id="analisisBody">

              </tbody>
            </table>
          </div>
          <div class="col-md-3">
            <table class="data-table table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Subtitulo</th>
                  <th>Mostrar</th>
                </tr>
              </thead>
              <tbody id="configuracionBody">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
