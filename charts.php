<?php

require_once("config.php");

$host= "PABX";
$ramal = $_POST['ramal-consulta'];
$ramalColaborador = NULL;
$idColaborador = NULL;


$ramalColaborador = verificaRamal($ramal);
$idColaborador = verificaIdUsuarioComercial($ramal);

 
$dataConsulta = $_POST['data-consulta'];

$sql = new Sql($host);

for ($i=8; $i <= 19; $i++) {
	
	$lista[$i] = $sql->select("SELECT COUNT(*) as numero_de_ligacoes, calldate, duration  FROM cdr WHERE calldate BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND src= $ramalColaborador AND duration > 60;");

	$lista[$i][0]['calldate'] = $i.':00:00';

}
$i=0;

foreach($lista as $conteudo)
{
	foreach($conteudo as $value)
	{
		$novoArray[$i] = $value;
		$i++;
	}	
}


//=========Inicio de Ligações Realizadas=========

$hostCRM= "CRM";

$sql = new Sql($hostCRM);

for ($i=10; $i <= 21; $i++)
{ 
	//Ligações com status "Held" = Realizadas
	//$listaCRM[$i] = $sql->select("SELECT COUNT(*) AS numero_de_ligacoes, date_entered  AS data FROM calls WHERE date_entered BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND assigned_user_id= '$idColaborador' AND status='Held'");

	//Ligações com qualquer status
	$listaCRM[$i] = $sql->select("SELECT COUNT(*) AS numero_de_ligacoes, date_entered  AS data FROM calls WHERE date_entered BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND assigned_user_id= '$idColaborador' AND status='Held'");	
	
	// Horario das ligações estão sendo gravadas no banco de dados do CRM com duas horas a mais, por isso essa subtração está sendo realizada. 
	$k = $i-2;

	$listaCRM[$i][0]['data'] = $k.':00:00';	
}

$i=0;

foreach($listaCRM as $conteudo){
	foreach($conteudo as $value){
		$novoArrayCRM[$i] = $value;
		$i++;
	}	
}


//=========Inicio de Ligações N Realizadas=========

$hostCRM= "CRM";

$sql = new Sql($hostCRM);

for ($i=10; $i <= 21; $i++)
{ 
	
	$listaCRM_N_R[$i] = $sql->select("SELECT COUNT(*) AS numero_de_ligacoes, date_entered  AS data FROM calls WHERE date_entered BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND assigned_user_id= '$idColaborador' AND status='Not Held'");	
	
	// Horario das ligações estão sendo gravadas no banco de dados do CRM com duas horas a mais, por isso essa subtração está sendo realizada. 
	$k = $i-2;

	$listaCRM_N_R[$i][0]['data'] = $k.':00:00';	
}

$i=0;

foreach($listaCRM_N_R as $conteudo){
	foreach($conteudo as $value){
		$novoArrayCRM_N_R[$i] = $value;
		$i++;
	}	
}

//=========Inicio de Ligações Reagendadas=========

$hostCRM= "CRM";

$sql = new Sql($hostCRM);

for ($i=10; $i <= 21; $i++)
{ 
	
	$listaCRM_Reagendadas[$i] = $sql->select("SELECT COUNT(*) AS numero_de_ligacoes, date_entered  AS data FROM calls_reschedule WHERE date_entered BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND created_by = '$idColaborador'");	
	
	// Horario das ligações estão sendo gravadas no banco de dados do CRM com duas horas a mais, por isso essa subtração está sendo realizada. 
	$k = $i-2;

	$listaCRM_Reagendadas[$i][0]['data'] = $k.':00:00';	
}

$i=0;
//print_r($listaCRM_Reagendadas);
//exit;

foreach($listaCRM_Reagendadas as $conteudo){
	foreach($conteudo as $value){
		$novoArrayCRM_Reagendadas[$i] = $value;
		$i++;
	}	
}


?>


<html>
  <head>
  	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="css/crm.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawMultSeries);

      function drawMultSeries() {
            var data = new google.visualization.DataTable();
            data.addColumn('timeofday', 'Time of Day');
            data.addColumn('number', 'PABX');
            data.addColumn('number', 'CRM_Realizada');
            data.addColumn('number', 'CRM_Não_Realizada');
            data.addColumn('number', 'Reagendada');

	      data.addRows([
	      	<?php $k=0; for ($i=8; $i <= 19; $i++) { ?>	      		
	      	
	        [{v: [<?php echo str_replace(":",",",$novoArray[$k]['calldate']) ?>], f: '<?php $nl = explode(":",$novoArray[$k]['calldate']); echo $nl[0]."hr"?>'},
	            <?php $n1=$novoArray[$k]['numero_de_ligacoes']; if($n1==0)$n1="0.1"; echo $n1 ?>,
                <?php $n2=$novoArrayCRM[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>,
                <?php $n2=$novoArrayCRM_N_R[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>,
                <?php $n2=$novoArrayCRM_Reagendadas[$k]['numero_de_ligacoes'];if($n2==0)$n2="0.1"; echo $n2 ?>
            ],
	       
	       <?php $k++;	 } ?>
	      ]);

	      var options = {
	      	  title: 'Numero de ligações em intervalos de 1 hora',
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
  </head>
  <body>
    <div  id="chart_div"></div>
    <a href="index.php" class="btn btn-info" role="button">Nova consulta</a>
  </body>
</html>

<?php


// FUNÇÔES

function verificaRamal($ramal){

	if($ramal == "Fernando"){
		$ramalColaborador = 7725;	
			
	}elseif($ramal == "Felipe"){
		$ramalColaborador = 7721;			
	
	}elseif($ramal == "Henrique Igor"){
		$ramalColaborador = 7742;
			
	}elseif($ramal == "Henrique Colchete"){
		$ramalColaborador = 7778;
			
	}elseif($ramal == "Iuri"){
		$ramalColaborador = 7748;
			
	}elseif($ramal == "Keli"){
		$ramalColaborador = 7722;
			
	}elseif($ramal == "Nuriele"){
		$ramalColaborador = 7730;
			
	}elseif($ramal == "Rayan"){
		$ramalColaborador = 7743;
			
	}elseif($ramal == "Rennan"){
		$ramalColaborador = 7741;
			
	}elseif($ramal == "Sabrina"){
		$ramalColaborador = 7744;
			
	}elseif($ramal == "Silvio"){
		$ramalColaborador = 7745;
			
	}elseif($ramal == "Thiago"){
		$ramalColaborador = 7727;
			
	}elseif($ramal == "Wilton"){
		$ramalColaborador = 7747;
			
	}
	else{
		$ramalColaborador = $ramal;
	}

	return $ramalColaborador;
}

function verificaIdUsuarioComercial($ramal){
	if($ramal == "Fernando"){
		$idColaborador = '8d25e62f-cb4e-72de-2b1c-52cd75f8f302';			
	}elseif($ramal == 7725){
		$idColaborador = '8d25e62f-cb4e-72de-2b1c-52cd75f8f302';	
	}elseif($ramal == "Felipe"){
		$idColaborador = 'b80e750c-28d0-f5f6-d165-5ad09922b21e';	
	}elseif($ramal == 7721){
		$idColaborador = 'b80e750c-28d0-f5f6-d165-5ad09922b21e';
	}

	return $idColaborador;	
}


?>