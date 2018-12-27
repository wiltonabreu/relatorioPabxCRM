<script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'bar']});
  google.charts.setOnLoadCallback(drawMultSeries);

  function drawMultSeries() {
        var data = new google.visualization.DataTable();
        data.addColumn('timeofday', 'Time of Day');
        data.addColumn('number', 'PABX');
        data.addColumn('number', 'Realizada');
        data.addColumn('number', 'Não Realizada');
        data.addColumn('number', 'Reagendada');

      data.addRows([
        <?php $k=0; for ($i=8; $i <= 19; $i++) { ?>             
        
        [{v: [<?php echo str_replace(":",",",$novoArray[$k]['calldate']) ?>], f: '<?php $nl = explode(":",$novoArray[$k]['calldate']); echo $nl[0]."hr"?>'},
            <?php $n1=$novoArray[$k]['numero_de_ligacoes']; if($n1==0)$n1="0.1"; echo $n1 ?>,
            <?php $n2=$novoArrayCRM[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>,
            <?php $n2=$novoArrayCRM_N_R[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>,
            <?php $n2=$novoArrayCRM_Reagendadas[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>
        ],
       
       <?php $k++;   } ?>
      ]);

      var options = {
          //isStacked: true,//Essa linha transforma o gráfico em pilha.
          width: 1024,
          height: 450,
          left: 300,             
          annotations: {
            alwaysOutside: true,
            textStyle: {
              fontSize: 14,                  
              color: '#000',
              auraColor: 'none'
            }
          },
          
          hAxis: {
            title: 'Horário',                    
            viewWindow: {
              min: [7, 30],
              max: [19, 30]
            }
          },
          vAxis: {
            title: 'Numero de Ligações'
          }
        };
        var chart = new google.visualization.ColumnChart(
          document.getElementById('chart_div'));

        chart.draw(data, options);
      }
</script>