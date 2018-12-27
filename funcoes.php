<?php


// FUNÇÔES

function verificaRamal($ramal){

    if($ramal == "Fernando"){
        $ramalColaborador = 7725;   
            
    }elseif($ramal == "Felipe"){
        $ramalColaborador = 7721;           
    
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