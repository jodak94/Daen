<script>
  $(document).ready(function(){
    var paciente;
    $("#add_paciente_button").on('click', function(){
      $("#error").hide();
      var nombre = $("#nombre").val();
      var apellido = $("#apellido").val();
      var fecha_nacimiento = $("#fecha_nacimiento").val();
      var cedula = $("#cedula").val();
      if(nombre == '' || apellido == '' || fecha_nacimiento == '' || cedula == '' ){
        $("#error").show();
        $("#error_message").html('Faltan completar campos');
        return;
      }
      $("#spin").show();
      $.ajax({
        url: "{{route('admin.pacientes.paciente.store_ajax')}}",
        type: 'POST',
        data: {
          'nombre': nombre,
          'apellido': apellido,
          'fecha_nacimiento': fecha_nacimiento,
          'cedula': cedula,
          'sexo': $('select[name=sexo]').val(),
          "_token": "{{ csrf_token() }}",
        },
        success: function(data){
          if(data.error){
            $("#error").show();
            $("#error_message").html(data.message);
          }else{
            $("#buscar-paciente").val(
              data.paciente.nombre + ' ' + data.paciente.apellido + '. Ci: ' + data.paciente.cedula
            )
            paciente = data.paciente
            $("#addPaciente").modal('hide');
            $("#paciente_id").val(data.paciente.id)
            $("#buscar-subseccion").prop("disabled", false)
          }
          $("#spin").hide();
        },
        error: function(error){
          $("#spin").hide();
          $("#error_message").html("Ocurrio un error en el servidor");
        }
      })
    })
    $("#buscar-paciente").autocomplete({
      source: '{{route('admin.pacientes.paciente.search_ajax')}}',
      select: function( event, ui){
        paciente = ui.item.paciente
        $("#paciente_id").val(ui.item.id)
        $("#buscar-subseccion").prop("disabled", false)
      }
    })
    $("#buscar-subseccion").autocomplete({
      source: '{{route('admin.analisis.subseccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        var html = trTitulo(ui.item.titulo, ui.item.id);
        $("#analisisBody").append(html)
        $.each(ui.item.determinacion, function(index, det){
          html
              ="<tr class='determinacion-"+ui.item.id+"'>"
              +"  <td>"+det.titulo+"</td>"
          switch (det.tipo_referencia) {
            case 'booleano':
              html += "<td>"
                   +  " <select class='form-control determinacion-select valor' name=determinacion["+det.id+"]>"
                   +  "   <option value='Negativo'>Negativo</option>"
                   +  "   <option value='Positivo'>Positivo</option>"
                   +  " </select>"
                   +  "</td>"
              break;
            case 'reactiva':
              html += "<td>"
                    +  " <select class='form-control valor' name=determinacion["+det.id+"]>"
                    +  "   <option value='No Reactiva'>No Reactiva</option>"
                    +  "   <option value='Reactiva'>Reactiva</option>"
                    +  " </select>"
                    +  "</td>"
              break;
            case 'rango':
              html += "<td><input class='form-control determinacion-rango valor' name=determinacion["+det.id+"]></td>"
              break;
            case 'rango_edad':
              html += "<td><input class='form-control determinacion-rango-edad valor' name=determinacion["+det.id+"]></td>"
              break;
            case 'rango_sexo':
              html += "<td><input class='form-control determinacion-rango-sexo valor' name=determinacion["+det.id+"]></td>"
              break;
            default:
              html += "<td><input class='form-control valor' name=determinacion["+det.id+"]></td>"

          }
          html
             +="  <td>"
              +     det.rango_referencia_format
              +"    <input type='hidden' class='rango-referencia' value='"+det.rango_referencia+"'>"
              +"  </td>"
              +"  <td class='center'>";
          if(det.tipo_referencia != 'sin_referencia')
          html
             +="    <input type='checkbox' class='rango-check flat-blue' id='check-"+det.id+"' name=fuera_rango["+det.id+"]>";
          html
             +="  </td>"
              +"  <td>"
              +"    <button subId="+ui.item.id+" type='button' class='btn btn-danger btn-flat delete-det'>"
              +"      <i class='fa fa-trash'></i>"
              +"    </button>"
              +"  </td>"
              +"</tr>"
          $("#analisisBody").append(html)

          $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
              checkboxClass: 'icheckbox_flat-blue',
              radioClass: 'iradio_flat-blue'
          });
        })
        $(this).val("")
        return false;
      }
    })
    $("#analisisBody").on('click', '.delete-det', function(){
      if($(".determinacion-"+$(this).attr('subId')).size() == 1)
        $(this).closest('tr').prev().remove()
      $(this).closest('tr').remove()
    })
    $("#analisisBody").on('click', '.delete-sub', function(){
      $(".determinacion-"+$(this).attr('subId')).remove()
      $(this).closest('tr').remove()
    })

    $(".table").on('keydown', '.determinacion-rango', function(event){
      if(event.keyCode == 9 || event.keyCode == 13){
        event.preventDefault();
        if(!$(this).closest("tr").is(":last-child"))
          $(this).closest('tr').next('tr').find('.valor').focus()
      }
      if(event.keyCode == 13 && $(this).closest("tr").is(":last-child"))
        $("#analisis-form").submit()
    })

    $(".table").on('keyup', '.determinacion-rango', function(event){
      let val = $(this).val()
      let rango = $(this).parent().parent().find('.rango-referencia').val();

      rango = rango.split('-')
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
      if(parseInt(val) < parseInt(rango[0]) || parseInt(val) > parseInt(rango[1])){
        $('#'+dom.id).iCheck('check');
      }else{
        $('#'+dom.id).iCheck('uncheck');
      }
    })

    $(".table").on('keyup', '.determinacion-rango-edad', function(event){
      let val = $(this).val()
      let rango = $(this).parent().parent().find('.rango-referencia').val();
      rango = rango.replace('|', '-').replace(/[^\d.-]/g,'');
      rango = rango.split('-')
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
      let min = 0;//Niño
      let max = 1;//Niño
      if(paciente.edad > 15){
        min = 2;
        max = 3;
      }
      if(parseInt(val) < parseInt(rango[min]) || parseInt(val) > parseInt(rango[max])){
        $('#'+dom.id).iCheck('check');
      }else{
        $('#'+dom.id).iCheck('uncheck');
      }
    })

    $(".table").on('keyup', '.determinacion-rango-sexo', function(event){
      console.log($(this).val())
    })

    $(".table").on('change', '.determinacion-select', function(event){
      console.log($(this).val())
    })

    $("#analisis-form").submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: 'post',
        url: $("#analisis-form").attr("action"),
        data: $("#analisis-form").serialize(),
        success: function(response) {
            if(!response.error){
              window.open('{{route("admin.analisis.analisis.exportar")}}?action=print&analisis_id='+response.analisis_id,"_blank");
              location.href = '{{route('admin.analisis.analisis.index')}}';
            }else
            $.toast({
              heading: 'Error',
              text: response.message,
              showHideTransition: 'slide',
              icon:'error',
              position: 'top-right'
            })
         },
       });
    });

  })
  function trTitulo(titulo, id){
    var html
        ="<tr class='tr-titulo'>"
        +"  <td colspan='4' style='text-align:center'>"
        +     "<u>"+titulo+"</u>"
        +   "</td>"
        +"  <td>"
        +"    <button subId='"+id+"' type='button' class='btn btn-danger btn-flat delete-sub'>"
        +"      <i class='fa fa-trash'></i>"
        +"    </button>"
        +"  </td>"
        +"</tr>"
    return html;
  }
</script>
