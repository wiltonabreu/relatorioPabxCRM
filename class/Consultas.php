<?php
class Consultas{

  public static function getList(){
	$sql = new Sql();
	//return $sql->select("SELECT calldate AS Data,src AS Origem,dst AS destino FROM cdr WHERE calldate > '2018-10-31' AND src= '7744' OR calldate > '2018-10-31' AND dst= '7744' AND duration >= 60;");
	
  }


  public static function search($query,$ramal,$data){
	$sql = new Sql();
	$sq = $sql->select($query, array(
	 ':RAMAL'=>$ramal,
	 ':DATA'=> $data
	));
	return $sq;
  }

public static function getNome($query,$id){
        $sql = new Sql();
        $stmt = $sql->selectNome($query, array(
         ':ID'=>$id
        ));

	
	return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        
  }


}

?>	
