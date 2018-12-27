<script type="text/javascript">
  google.charts.load('current', {'packages':['table']});
  google.charts.setOnLoadCallback(drawTable);

  function drawTable() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Nome/Ramal');
    data.addColumn('number', 'Data');
    data.addColumn('string', 'Tempo');
    data.addColumn('number', 'PABX');
    data.addColumn('number', 'Realizadas');
    data.addColumn('number', 'Não Realizadas');
    data.addColumn('number', 'Reagendadas');
    
    data.addRows([
      ['<?php echo $ramal?>',  {v: <?php echo $dataConsulta?>, f: '<?php echo date('d/m/Y',  strtotime($dataConsulta))?>'},'<?php echo " > ".$tempoMinimo . " segundos"?>', <?php echo $n_l_Pabx?>,<?php echo $n_l_CRM_Realizadas?>,<?php echo $n_l_CRM_N_Realizadas?>, <?php echo $n_l_CRM_Reagendadas?>]
      
    ]);

    var table = new google.visualization.Table(document.getElementById('table_div'));

    table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
  }
</script>