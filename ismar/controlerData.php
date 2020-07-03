<?php
require_once('../vsi.php'); verificaToken(887766);
require_once '../database.php';


$conexao = new bd();

$dados = $_POST;


if ($_GET['tipo']=='temporal'){

    $resultBD = $conexao->buscaString("select date_format(tempo_ini, '%m') as 'Mes', count(*) as 'Quantidade' from log where (tempo_ini between '2020-01-01' and '2020-12-31') group by Mes");

    $rows=array();
    $data = array();

    while($resultados = $resultBD->fetch(PDO::FETCH_ASSOC)) {


        //$data[] = array($resultados['id'], $resultados['id_usuario']);

        $cell0["v"]=$resultados['Mes'];
        $cell1["v"]=$resultados['Quantidade'];
        $cell2["v"]=$resultados['Quantidade'];
        $row["c"]=array($cell0,$cell1,$cell2);

        array_push($rows,$row);
    }

    $col1=array();
    $col1["id"]="";
    $col1["label"]="Topping";
    $col1["pattern"]="";
    $col1["type"]="string";
    //$col1["role"]="annotation";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Nível de acessos";
    $col2["pattern"]="";
    $col2["type"]="number";

    $col3=array();
    $col3["type"]="string";
    $col3["role"]="annotation";

    $cols = array($col1,$col2,$col3);

    $inf['data']='30-03-20';
    $inf['qtd1']='200';
    $inf['qtd2']='400';
    $inf['qtd3']='600';

    $data=array("dados"=>$inf);


    echo json_encode($data);



}else if ($_GET['tipo'] == 'acessoSegmentado'){

    $resultBD = $conexao->buscaString("select date_format(tempo_ini, '%d') as 'Dia', count(*) as 'Quantidade' from log where (tempo_ini between '2020-03-01' and '2020-04-01') AND (tipo = 'ACESSO') group by Dia");

    $rows=array();
    $data = array();

    while($resultados = $resultBD->fetch(PDO::FETCH_ASSOC)) {


        //$data[] = array($resultados['id'], $resultados['id_usuario']);

        $cell0["v"]=$resultados['Dia'];
        $cell1["v"]=$resultados['Quantidade'];
        $cell2["v"]=$resultados['Quantidade'];
        $row["c"]=array($cell0,$cell1,$cell2);

        array_push($rows,$row);
    }

    $col1=array();
    $col1["id"]="";
    $col1["label"]="Topping";
    $col1["pattern"]="";
    $col1["type"]="string";
    //$col1["role"]="annotation";

    $col2=array();
    $col2["id"]="";
    $col2["label"]="Nível de acessos";
    $col2["pattern"]="";
    $col2["type"]="number";

    $col3=array();
    $col3["type"]="string";
    $col3["role"]="annotation";

    $cols = array($col1,$col2,$col3);


    $data=array("cols"=>$cols,"rows"=>$rows);
    //print_r($data);
    echo json_encode($data);


}else if ($_GET['tipo'] == 'pizzaAtividades'){

    $resultBD = $conexao->buscaString("select descricao,COUNT(*) AS num_atividades from log where (atividade = 'visualizou_pagina') GROUP BY descricao");

    $rows=array();
    $data = array();

    while($resultados = $resultBD->fetch(PDO::FETCH_ASSOC)) {


        $cell0["v"]=$resultados['descricao'];
        $cell0["f"]=null;
        $cell1["v"]=(int)$resultados['num_atividades'];
        $cell1["f"]=null;
        $row["c"]=array($cell0,$cell1);

        array_push($rows,$row);
    }

    $col1=array();
    $col1["id"]="1";
    $col1["label"]="Atividades";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="2";
    $col2["label"]="Acessos";
    $col2["pattern"]="";
    $col2["type"]="number";

    $cols = array($col1,$col2);

    $data=array("cols"=>$cols,"rows"=>$rows);

    echo json_encode($data);


}else if ($_GET['tipo'] == 'grantAtividade'){

    $resultBD = $conexao->buscaString("select descricao,COUNT(*) AS num_atividades from log where (atividade = 'visualizou_pagina') GROUP BY descricao");

    $rows=array();
    $data = array();

    while($resultados = $resultBD->fetch(PDO::FETCH_ASSOC)) {


        $cell0["v"]=$resultados['descricao'];
        $cell0["f"]=null;

        $cell1["v"]='bncc';
        $cell1["f"]=null;

        $cell2["v"]='BNCC';
        $cell2["f"]=null;

        $cell3["v"]=new Date(2014, 2, 22);
        $cell3["f"]=null;

        $cell4["v"]=new Date(2014, 2, 22);
        $cell4["f"]=null;

        $cell5["v"]=new Date(2014, 2, 22);
        $cell5["f"]=null;

        $row["c"]=array($cell0,$cell1,$cell2,$cell3,$cell4,$cell5);


        array_push($rows,$row);
    }

    $col1=array();
    $col1["id"]="1";
    $col1["label"]="Task ID";
    $col1["pattern"]="";
    $col1["type"]="string";

    $col2=array();
    $col2["id"]="2";
    $col2["label"]="Task Name";
    $col2["pattern"]="";
    $col2["type"]="string";

    $col3=array();
    $col3["id"]="3";
    $col3["label"]="Resource";
    $col3["pattern"]="";
    $col3["type"]="string";

    $col4=array();
    $col4["id"]="4";
    $col4["label"]="Start Date";
    $col4["pattern"]="";
    $col4["type"]="date";

    $col5=array();
    $col5["id"]="4";
    $col5["label"]="End Date";
    $col5["pattern"]="";
    $col5["type"]="date";

    $col6=array();
    $col6["id"]="4";
    $col6["label"]="Duration";
    $col6["pattern"]="";
    $col6["type"]="number";

    $col7=array();
    $col7["id"]="4";
    $col7["label"]="Percent Complete";
    $col7["pattern"]="";
    $col7["type"]="number";

    $col8=array();
    $col8["id"]="4";
    $col8["label"]="Dependencies";
    $col8["pattern"]="";
    $col8["type"]="string";

    $cols = array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);

    $data=array("cols"=>$cols,"rows"=>$rows);

    echo json_encode($data);


}

unset($conexao);
?>