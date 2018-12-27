<?php
$host= "PABX";
$ramal = $_POST['ramal-consulta'];
$ramalColaborador = NULL;
$idColaborador = NULL;
$tempoMinimo = 0;


$ramalColaborador = verificaRamal($ramal);
$idColaborador = verificaIdUsuarioComercial($ramal);

 
$dataConsulta = $_POST['data-consulta'];
$tempoMinimo = $_POST['tempo-consulta'];

$sql = new Sql($host);

for ($i=8; $i <= 19; $i++) {
    
    $lista[$i] = $sql->select("SELECT COUNT(*) as numero_de_ligacoes, calldate, duration  FROM cdr WHERE calldate BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND src= $ramalColaborador AND duration > $tempoMinimo;");

    $lista[$i][0]['calldate'] = $i.':00:00';

}
$i=0;
$n_l_Pabx = 0;
foreach($lista as $conteudo)
{
    foreach($conteudo as $value)
    {
        $novoArray[$i] = $value;
        $n_l_Pabx = $n_l_Pabx + $novoArray[$i]['numero_de_ligacoes'];
        $i++;
    }   
}
//print_r($novoArray);
//echo $n_l_Pabx;
//exit;

//=========Inicio de Ligações Realizadas=========

$hostCRM= "CRM";

$sql = new Sql($hostCRM);

for ($i=10; $i <= 21; $i++)
{ 
    
    $listaCRM[$i] = $sql->select("SELECT COUNT(*) AS numero_de_ligacoes, date_entered  AS data FROM calls WHERE date_entered BETWEEN '$dataConsulta' ' $i:00:00' AND '$dataConsulta' ' $i:59:59' AND assigned_user_id= '$idColaborador' AND status='Held'");    
    
    // Horario das ligações estão sendo gravadas no banco de dados do CRM com duas horas a mais, por isso essa subtração está sendo realizada. 
    $k = $i-2;

    $listaCRM[$i][0]['data'] = $k.':00:00'; 
}

$i=0;
$n_l_CRM_Realizadas = 0;
foreach($listaCRM as $conteudo){
    foreach($conteudo as $value){
        $novoArrayCRM[$i] = $value;
        $n_l_CRM_Realizadas = $n_l_CRM_Realizadas + $novoArrayCRM[$i]['numero_de_ligacoes'];
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
$n_l_CRM_N_Realizadas = 0;
foreach($listaCRM_N_R as $conteudo){
    foreach($conteudo as $value){
        $novoArrayCRM_N_R[$i] = $value;
        $n_l_CRM_N_Realizadas = $n_l_CRM_N_Realizadas + $novoArrayCRM_N_R[$i]['numero_de_ligacoes'];
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
$n_l_CRM_Reagendadas = 0;
foreach($listaCRM_Reagendadas as $conteudo){
    foreach($conteudo as $value){
        $novoArrayCRM_Reagendadas[$i] = $value;
        $n_l_CRM_Reagendadas = $n_l_CRM_Reagendadas + $novoArrayCRM_Reagendadas[$i]['numero_de_ligacoes'];
        $i++;
    }   
}
?>