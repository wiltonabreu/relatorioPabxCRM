<script type="text/javascript">
  google.charts.load('current', {'packages':['table']});
  google.charts.setOnLoadCallback(drawTable);

  function drawTable() {
    var data = new google.visualization.DataTable();
    
    data.addColumn('timeofday', 'Horario');
        data.addColumn('number', 'PABX');
        data.addColumn('number', 'Realizada');
        data.addColumn('number', 'Não Realizada');
        data.addColumn('number', 'Reagendada');

      data.addRows([
        <?php $k=0; for ($i=8; $i <= 19; $i++) { ?>             
        
        [{v: [<?php echo str_replace(":",",",$novoArray[$k]['calldate']) ?>], f: '<?php $nl = explode(":",$novoArray[$k]['calldate']); echo $nl[0]."h"?>'},
            <?php $n1=$novoArray[$k]['numero_de_ligacoes'];  echo $n1 ?>,
            <?php $n2=$novoArrayCRM[$k]['numero_de_ligacoes']; echo $n2 ?>,
            <?php $n2=$novoArrayCRM_N_R[$k]['numero_de_ligacoes']; echo $n2 ?>,
            <?php $n2=$novoArrayCRM_Reagendadas[$k]['numero_de_ligacoes']; echo $n2 ?>
        ],
       
       <?php $k++;   } ?>
      ]);

    var table = new google.visualization.Table(document.getElementById('charts_table'));

    table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
  }
</script>