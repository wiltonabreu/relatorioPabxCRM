<!DOCTYPE html>
<html>

<head>
    
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/crm.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <meta charset="UTF-8">

    <title>Gráficos em PHP com Charts</title>          

</head>

<body>
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    
    <div class="container" id="formulario-container">                   
        <form method="POST" action="#">
            <div class="form-row">

                <div class="col-md-4">
                        
                    <label for="ramal-consulta" id="label-ramal" >Ramal</label>
                    <input id="input-ramal" type="text" list="ramal-consulta" class="form-control" name="ramal-consulta" required></input>
                    <datalist id="ramal-consulta">
                        <option value="Fernando">
                        <option value="Felipe">     
                    </datalist> 
                    
                </div>
           

            
                <div class="col-md-4">
                 <label for="data-consulta">Data</label>
                 <input type="date" class="form-control" id="data-consulta" name="data-consulta" required max="<?php echo date("Y-m-d");?>">
                </div>

                <div class="col-md-4">
                 <label for="tempo-consulta">Tempo minimo em ligação</label>
                 <input type="number" class="form-control" id="tempo-consulta" name="tempo-consulta" required min=15>
                </div>
                           
             </div>
            <div class="row buttons"> 
                <button type="submit" id="btn-submit" class="btn btn-primary" tabindex="5">Consultar</button>
                <button type="reset" id="btn-reset" class="btn btn-secondary" tabindex="5">Limpar</button>
            </div>                 
                                      
        </form>
    </div> 

    <div id="chart_div" ></div>

    <div id="table_div" ></div>
   
    <div id="icone">
        <a href="#"><i class="fas fa-equals"></i></a>
    </div>
   
    <div id="charts_table"></div>
          
        
</body>
</html>


<?php
require_once("config.php");
require_once("funcoes.php");
require_once("dados.php");
require_once("charts/colum_charts.php");
require_once("charts/table_charts_total.php");
require_once("charts/table_charts.php");
?>
