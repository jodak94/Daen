<script type="text/javascript">
$( document ).ready(function(){
    var totales_mes = <?php echo json_encode($totales_mes); ?>;
    var meses = <?php echo json_encode($meses); ?>;
    var ventas = document.getElementById("ventas").getContext("2d");
    var ventaChart = new Chart(ventas, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Total',
                data: totales_mes,
                backgroundColor:'rgba(255, 255, 255, 0.15)',
                borderColor: 'rgba(53, 124, 165, 1)',
                borderWidth: 3
            }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                  callback: function(label, index, labels) {
                      let n = new Intl.NumberFormat().format(label)
                      return n;
                  },
                  beginAtZero: true
              },
              scaleLabel: {
                  display: true,
                  labelString: 'Guaraníes'
              }
            }]
          },
          tooltips: {
           callbacks: {
               label: function(tooltipItem, data) {
                 let n = new Intl.NumberFormat().format(tooltipItem.yLabel)
                 return n + ' Gs.';
               }
           }
         }
        }
    });

    $("#year").on('change', function(){
      let url = $('#yearUrl').attr('href');
      $('#yearUrl').attr('href', url.substring(0, url.indexOf('?') + 1) + 'year=' + $(this).val())
      getPerYear($(this).val());
    })

    function getPerYear(year){
      $.ajax({
        url: '{{route('admin.informes.informe.perYearAjax')}}',
        type: 'GET',
        data: {
          'year': year,
        },
        success: function(data){
          if(!data.error){
            let dataset = {
                label: year,
                data: data.totales_mes,
                backgroundColor:'rgba(255, 255, 255, 0.15)',
                borderColor: 'rgba(53, 124, 165, 1)',
                borderWidth: 3
            }
            ventaChart.data.datasets[0] = dataset;
            ventaChart.data.labels = data.meses;
            ventaChart.update();
          }
        },
      })
    }

    $("#yearM").on('change', function(){
      let mes1 = $("[name=mes]").val();
      let mes2 = $("[name=mes2]").val();
      getPerDay(mes1, 0, 'rgba(53, 124, 165, 1)', $(this).val())
      if(mes2 >= 0)
        getPerDay(mes2, 1, 'rgba(168, 6, 21, 1)', $(this).val())
    })

    $("[name=mes]").on('change', function(){
      let mes = $(this).val();
      let year = $('#yearM').val();
      $('[name=mes2] option').removeAttr('disabled')
      $('[name=mes2] option[value="' + mes + '"]').attr('disabled', true)
      getPerDay(mes, 0, 'rgba(53, 124, 165, 1)', year)
    })
    $("[name=mes2]").on('change', function(){
      let mes = $(this).val();
      let year = $('#yearM').val();
      if(mes == -1){
        $('[name=mes] option').removeAttr('disabled')
        ventaDiaChart.data.datasets.pop();
        ventaDiaChart.update();
      }else{
        $('[name=mes] option').removeAttr('disabled')
        $('[name=mes] option[value="' + mes + '"]').attr('disabled', true)
        getPerDay(mes, 1, 'rgba(168, 6, 21, 1)', year)
      }
    })

    function getPerDay(mes, index, borderColor, year){
      $.ajax({
        url: '{{route('admin.informes.informe.perDayAjax')}}',
        type: 'GET',
        data: {
          'mes': mes,
          'year': year,
        },
        success: function(data){
          if(!data.error){
            let dataset = {
                label: data.mes,
                data: data.total_dias,
                backgroundColor:'rgba(255, 255, 255, 0.15)',
                borderColor: borderColor,
                borderWidth: 3
            }
            ventaDiaChart.data.datasets[index] = dataset;
            if(ventaDiaChart.data.datasets.length == 1)
              ventaDiaChart.data.labels = data.dias;
            else
              if(data.dias.length > ventaDiaChart.data.labels.length)
                ventaDiaChart.data.labels = data.dias;
            ventaDiaChart.update();
          }
        },
      })
    }

    var total_dias = <?php echo json_encode($total_dias); ?>;
    var dias = <?php echo json_encode($dias); ?>;
    var dias_label = '{{$meses[$mes_actual - 1]}}'
    var ventas_dia = document.getElementById("ventas_dia").getContext("2d");
    var ventaDiaChart = new Chart(ventas_dia, {
        type: 'line',
        data: {
            labels: dias,
            datasets: [{
                label: dias_label,
                data: total_dias,
                backgroundColor:'rgba(255, 255, 255, 0.15)',
                borderColor: 'rgba(53, 124, 165, 1)',
                borderWidth: 3
            }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                  callback: function(label, index, labels) {
                      let n = new Intl.NumberFormat().format(label)
                      return n;
                  },
                  beginAtZero: true
              },
              scaleLabel: {
                  display: true,
                  labelString: 'Guaraníes'
              }
            }]
          },
          tooltips: {
           callbacks: {
               label: function(tooltipItem, data) {
                 let n = new Intl.NumberFormat().format(tooltipItem.yLabel)
                 return n + ' Gs.';
               }
           }
         }
        }
    });
});

</script>
