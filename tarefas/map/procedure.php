<?php

//require_once('https://sistemasdeensino.mackenzie.br/vsi.php'); verificaToken(887766);
require_once '../../database.php';

$conexao = new bd();


$resultado = $conexao->buscaString("select * from usuarios LIMIT 110");

$data = array();
$usuario = array();
$nodes = array();
$links = array();


$nodes[] =  array('id' => '101', 'name'=>'Diretrizes', 'group'=>'0');
$nodes[] =  array('id' => '102', 'name'=>'Material', 'group'=>'0');
$nodes[] =  array('id' => '103', 'name'=>'10_Razoes', 'group'=>'0');
$nodes[] =  array('id' => '201', 'name'=>'BNCC_na_Escola', 'group'=>'1');
$nodes[] =  array('id' => '202', 'name'=>'Plano_Curricular', 'group'=>'1');
$nodes[] =  array('id' => '203', 'name'=>'Modulos_BNCC', 'group'=>'1');
$nodes[] =  array('id' => '204', 'name'=>'Mais_que_BNCC', 'group'=>'1');
$nodes[] =  array('id' => '301', 'name'=>'Textos_Cosmovisao', 'group'=>'2');
$nodes[] =  array('id' => '302', 'name'=>'Videos_Cosmovisao', 'group'=>'2');
$nodes[] =  array('id' => '401', 'name'=>'Textos_Fonico', 'group'=>'3');
$nodes[] =  array('id' => '402', 'name'=>'Videos_Fonico', 'group'=>'3');
$nodes[] =  array('id' => '403', 'name'=>'Curso_Fonico', 'group'=>'3');



   $y = 0;
while($resultados = $resultado->fetch(PDO::FETCH_ASSOC)) {

    if(($y > 20) and ($y < 100)){
        for ($i = 0; $i <= 10; $i++) {

            $rand1 = rand(0,11);
            $rand2 = rand(0,11);
            $rand3 = rand(0,100);

            $links[] =  array('source'=>$rand1, 'target'=>$rand2, 'value'=>$rand3);
        }
    }else{
        for ($i = 0; $i <= 10; $i++) {
            $links[] =  array('source'=>$i, 'target'=>$i+1, 'value'=>0);
        }
        
    }
    $y++;
    
    $usuario[] = array(
        "id" =>$resultados['id'], 
        "nome" => $resultados['nome'],
        "nodes" => $nodes,
        "links" => $links
    );
   
  $links = array();
    
}



$data = array("usuario"=>$usuario);
echo json_encode($data);



?>