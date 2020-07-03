<?php
/*
 * ID: 301
 * DESCRICAO: Tela para cadastro dos alunos (Ensino Infantil, Fundamental I, Fundamental II e Ensino Medio)
 * GRUPO: SEC
 *
 *
 */
require_once ('../vsi.php'); $acesso = verificaToken(306);
require_once '../database.php';


    function betoCrypt($string,$action) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'beto';
        $secret_iv = 'douglas';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'e' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'd' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    $utilizador = $_SESSION['id_escola'];

    if (isset($_GET['id'])){
        $utilizador = $_GET['id'];
    }

    echo '<script>var utilizador = "'. $utilizador .'";</script>';


    $conexao = new bd();

    $resultado = $conexao->buscaTodosPedidos();
    $pedidos= $resultado->fetchAll(PDO::FETCH_ASSOC);

    unset($conexao);


    function status($num){

        $statusTexto = ['Em Processamento', 'Pedido Recebido', 'Em Análise', 'Em Separação', 'Enviado', 'Concluído','Cancelado'];
        $statusCores = ['statusRed','statusOrange','statusYellow','statusBlue','statusPurple','statusGreen','statusSilver'];

        if($num != '99'){
            $status = [$statusTexto[$num-1],$statusCores[$num-1]];
        }else{
            $status = [$statusTexto[6],$statusCores[6]];
        }


        return $status;

    }





?>
<style>
    div.dataTables_processing { z-index: 1; }

    body .container.body .right_col {
        background: white;
    }

    .botaoRedondo{
        background: white;
        border: 1px solid;
        border-radius: 20px;
        padding: 5 20 5 20;
        color: #00547f;
    }

    .botaoRedondo:hover{
        background: #00547f;
        color: white;
    }

    .titulo{
        font-size: 40px;
        color: #2a3f54;
        font-weight: 500;
        margin-left: 80px;
    }

    .sub-titulo{
        color: #737373;
        margin: 0px 0 6px;
        font-style: italic;
        font-size: 16px;
    }

    .meusPedidos{
        margin: 20px;
        margin-top: 40px;
    }


    .desativa{
        background: #999494;
        color: white;
    }


    .statusRed{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #e45061;
        color: #e45061;
        width: 1px;
        display: inline-block;
    }

    .statusOrange{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #e4a440;
        color: #e4a440;
        width: 1px;
        display: inline-block;
    }

    .statusYellow{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #e4cf0d;
        color: #E4CF0D;
        width: 1px;
        display: inline-block;
    }

    .statusBlue{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #0089e4;
        color: #0089e4;
        width: 1px;
        display: inline-block;
    }

    .statusPurple{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #9345e4;
        color: #9345e4;
        width: 1px;
        display: inline-block;
    }

    .statusGreen{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #00e48d;
        color: #00e48d;
        width: 1px;
        display: inline-block;
    }

    .statusSilver{
        border: 1px solid;
        border-radius: 50px;
        padding: 5 5 5 5;
        margin-right: 10px;
        background-color: #9d9ea5;
        color: #9d9ea5;
        width: 1px;
        display: inline-block;
    }

    .escolha{
        width: 30%;
        border: 1px solid white;
        background-color: white;
        border-radius: 20px;
        margin: 10px;
        padding: 20;
    }

    .escolha:hover{
        border: 2px solid #00547f;
        cursor: pointer;
    }

    .escolhaTitulo{
        font-size: 14px;
        font-weight: 300;
        color: #00547f;
        text-align: center;
    }

    .escolhaTipo{
        font-size: 26px;
        font-weight: 500;
        color: #00547f;
        text-align: center;
        line-height: 1;
    }

    .escolhaImg{
        width: 100%;
        height: 150px;
        padding: 10;
    }


    table, tr, td, th
    {
        /*border-collapse:collapse;*/

    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #e5e5e5;
    }
    tr.headert
    {
        cursor:pointer;
        background-color: #e5e5e5;
        color: black!important;
        font-weight: 300;
        font-size: 15px;
    }

    tr.headert:hover
    {
        background-color: #f9f9f9 !important;
    }

    .impar{
        background-color: #f3f1f1!important;
    }

    .impar:hover{
        background-color: #f3f1f1!important;
    }

    .headert td{
        padding: 15px!important;
    }

    .tableCabecalho{
        font-size: 15px;
        color: #646464!important;
        font-style: italic;
    }

    .tableConteudo{
        background-color: #f9f9f9!important;
        display: none;
        color: black;
        font-weight: 300;
    }

    .tableCabecalho th{
        padding: 15px!important;
    }

    .drop{
        background-color: #e5e5e5!important;
        color: black!important;
        font-weight: 300;
        border-radius: 10px;
    }

    .dropMenu{
        background-color: #f9f9f9!important;
        color: #787878!important;
        /*width: 100%;*/
        padding-right: 10px;
    }

    .dropMenu li a{
        font-weight: 300;
        font-size: 15px;
        padding: 5 5 5 13;
    }

    .detalhesPedido{
        font-size: 16px;
        font-weight: 400;
        font-style: italic;
        margin-top: 30;
        /*margin-bottom: 40px;*/
    }

    .botaoVisualizar{
        background: #00547f;
        border: 1px solid;
        border-radius: 20px;
        /*padding: 5 20 5 20;*/
        color: #FFFFFF;
        font-size: 0.9vw;
        height: 30px;
        width: 100%;
    }

    .botaoSalvar{
        background: #6cd166;
        border: 1px solid;
        border-radius: 20px;
        /*padding: 5 20 5 20;*/
        color: #FFFFFF;
        font-size: 0.9vw;
        height: 30px;
        width: 100%;
    }

    .inputDados{
        border-radius: 10px;
        background-color: #e5e5e5;
        border: 1px solid #6b6b6b;
        padding: 0 8 0 8;
        height: 34px;
    }

    .btnLote{
        background: #00547f;
        border: 1px solid;
        border-radius: 20px;
        /*padding: 5 20 5 20;*/
        color: #FFFFFF;
        font-size: 0.7vw;
        height: 30px;
        width: 100%;
    }

    .btnLote:hover{
        background: #FFFFFF;
        color: #00547f;
    }

    .btnLote:disabled{
        background: #ccd2c3;
    }

    .datepicker{
        cursor: pointer;
    }

    .datepicker .form-control:first-child{
        border-radius: 10px 0px 0px 10px!important;
        background-color: #e5e5e5;
        border: 1px solid #6b6b6b;
        font-size: 15px!important;
        color: black!important;
    }


    .input-group.date .input-group-addon{
        border-radius: 0px 10px 10px 0px!important;
        background-color: #e5e5e5!important;
        border: 1px solid #6b6b6b!important;
    }
</style>

<link rel="stylesheet" href="../vendors/datatables/dataTables.bootstrap4.css">


<!-- page content -->
<div id="main" class="meusPedidos">
    <div class="page-title">

        <div class="row">
            <div class="col-md-8">
                <div class="titulo">Pedidos</div>
            </div>
            <div class="col-md-4">

                <div class="input-group" style="padding-top: 15px;">
                    <input id="filtro-nome" type="text" class="form-control" aria-label="..." style="border-radius: 20px 0px 0px 20px;">
                    <div class="input-group-btn">
                        <button id="tituloBusca" data="n" style="border-radius: 0px 20px 20px 0px;" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Todos <span class="caret"></span></button>
                        <ul id="dropBusca" class="dropdown-menu dropdown-menu-right" style="margin-left: -85px;font-size: 14px;width: fit-content;">
                            <li><a href="#" id="2">Número do Pedido</a></li>
                            <li><a href="#" id="3">Data do Pedido</a></li>
                            <li><a href="#" id="4">ID da escola</a></li>
                            <li><a href="#" id="5">Nome da escola</a></li>
                            <li><a href="#" id="7">Status</a></li>
                            <li><a href="#" id="8">Tipo</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" id="n">Todos</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->

            </div>
        </div>






        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="sub-titulo">

                        <ul class="nav navbar-right panel_toolbox">

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                                <table id="datatablePedidos" class="table table-striped dt-responsive nowrap cell-border" cellpadding="10" width="100%">
                                    <thead>
                                    <tr class="tableCabecalho">
                                        <th class="col-md-1" style="width: 5%!important;"></th>
                                        <th class="col-md-1" style="width: 10%!important;">Número do Proc</th>
                                        <th class="col-md-1" style="width: 13%!important;">Data do Pedido</th>
                                        <th class="col-md-1" style="width: 10%!important;">ID Escola</th>
                                        <th class="col-md-3" style="width: 30%!important;" >Escola</th>
                                        <th class="col-md-1" style="width: 5%!important;">Linhas</th>
                                        <th class="col-md-1" style="width: 5%!important;">Itens</th>
                                        <th class="col-md-1" style="width: 15%!important;">Status</th>
                                        <th class="col-md-1" style="width: 10%!important;">Tipo</th>
                                        <td class="col-md-1" style="width: 5%!important;"></td>
                                    </tr>
                                    </thead>
                                    <tbody>



                                    <!-- POPULANDO COM PHP -->
                                    <script>
                                        var pedidos = [];
                                        var statuspedidos = [];
                                    </script>
                                    <?php
                                    $cor = 0;
                                    foreach($pedidos as $pedido) {
                                    $cor = $cor +1;

                                    $dia= substr($pedido['previsao'], 8);
                                    $mes= substr($pedido['previsao'], 5,-3);
                                    $ano= substr($pedido['previsao'], 0,-6);
                                    $pedido['previsao'] = $dia."/".$mes."/".$ano;

                                    ?>
                                    <script>
                                        pedidos.push('<?php echo $pedido['num_processamento'] ?>');
                                        statuspedidos.push('<?php echo $pedido['status'] ?>');
                                    </script>
                                    <tr class="headert <?php if($cor % 2 == 0){ echo 'impar';} ?>" >
                                        <td class="col-md-1" style="width: 5%!important;" onclick="expandir(this)"> <div class="glyphicon glyphicon-chevron-right"></div> </td>
                                        <td class="col-md-1" style="width: 10%!important;" onclick="expandir(this)"><?php echo $pedido['num_processamento'] ?></td>
                                        <td class="col-md-1 hidden-xs" style="width: 13%!important;" onclick="expandir(this)"><?php echo $pedido['dataPedido'] ?></td>
                                        <td class="col-md-1 hidden-xs" style="width: 10%!important;" onclick="expandir(this)"><?php echo $pedido['escola_id'] ?></td>
                                        <td class="col-md-3 hidden-xs" style="width: 30%!important;" onclick="expandir(this)"><?php echo $pedido['escola'] ?></td>
                                        <td class="col-md-1 hidden-xs"  style="width: 3%!important;"onclick="expandir(this)"><?php echo $pedido['linhas'] ?></td>
                                        <td class="col-md-1 hidden-xs"  style="width: 3%!important;"onclick="expandir(this)"><?php echo $pedido['Itens'] ?></td>
                                        <td class="col-md-1 hidden-xs" style="width: 15%!important;"onclick="expandir(this)">
                                            <div id="pedidoStatus<?php echo $pedido['id']; ?>" class="<?php echo status($pedido['status'])[1]?>"></div><div id="pedidoStatusNome<?php echo $pedido['id']; ?>" style="display: inline;;"><?php echo status($pedido['status'])[0]?></div>
                                        </td>
                                        <td class="col-md-1" style="width: 10%!important;"><?php echo $pedido['categoria'] ?></td>
                                        <td class="col-md-1" style="width: 5%!important;"><div id="s<?php echo $pedido['num_processamento']; ?>"><img height="40px" src="pedidos/img/loading.svg"/></div><!-- <div class="glyphicon glyphicon glyphicon-ok" style="color: #00547f;font-size: small;">--></td>
                                    </tr>
                                    <tr class="tableConteudo">
                                        <td colspan="9">

                                            <div class="col-md-12" style="padding: 0 80 20 80;">
                                                <div class="row">
                                                    <div class="col-md-10 detalhesPedido" processamento="<?php echo $pedido['num_processamento'] ?>">
                                                        Detalhes do Pedido
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btnLote" <?php if($pedido['num_processamento'] != '00000000000000000000'){ echo 'disabled=true';} ?> onclick="enviarLote(<?php echo $pedido['id']; ?>,this,'<?php echo $pedido['categoria']; ?>')">Reenviar Lote</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">

                                                    </div>
                                                    <div class="col-md-2">
                                                        <div data="btnGroup" class="btn-group" style="margin-bottom: 20px;">
                                                            <button id="status<?php echo $pedido['id']; ?>" data="<?php echo $pedido['status']; ?>" id="dropTitulo" type="button" class="btn btn-default dropdown-toggle drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <div class="<?php echo status($pedido['status'])[1]?>"></div><?php echo status($pedido['status'])[0]?> <div class="caret"></div>
                                                            </button>
                                                            <ul   data="ul" id="dropStatus" class="dropdown-menu dropMenu">
                                                                <li><a href="#" status="1"> <div class="statusRed"></div>Em Processamento</a></li>
                                                                <li><a href="#" status="2"> <div class="statusOrange"></div>Pedido Recebido</a></li>
                                                                <li><a href="#" status="3"> <div class="statusYellow"></div>Em Análise</a></li>
                                                                <li><a href="#" status="4"> <div class="statusBlue"></div>Em Separação</a></li>
                                                                <li><a href="#" status="5"> <div class="statusPurple"></div>Enviado</a></li>
                                                                <li><a href="#" status="6"> <div class="statusGreen"></div>Concluído</a></li>
                                                                <li><a href="#" status="99"> <div class="statusSilver"></div>Cancelado</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-3" style="padding: 1px; width: auto; display: none;">
                                                        No. do Oracle: <input class="inputDados" id="oracle<?php echo $pedido['id']; ?>" value="<?php echo $pedido['numPedido'] ?>" disabled><i style="padding-left: 5px;     padding-right: 5px;cursor: pointer;" class="fa fa-pencil" onclick="edit(this)" data-toggle="tooltip" title="Editar código do Oracle"></i>
                                                    </div>
                                                    <div class="col-md-3" style="padding: 1px; width: auto;">
                                                        Nota Fiscal: <input class="inputDados" id="nf<?php echo $pedido['id']; ?>" value="<?php echo $pedido['nf'] ?>" disabled><i style="padding-left: 5px;     padding-right: 5px; cursor: pointer;" class="fa fa-pencil" onclick="edit(this)"></i>
                                                    </div>
                                                    <div class="col-md-4" style="padding: 1px; width: auto; display: flex;">
                                                        <div style="line-height: 2.3;padding-right: 5px;">Previsão de Entrega:</div>
                                                        <div class='input-group date datepicker' >
                                                            <input type='text' class="form-control previsao" id="previsao<?php echo $pedido['id']; ?>" value="<?php echo $pedido['previsao'] ?> "/>
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                        <!--Previsão de Entrega: <input class="inputDados" id="previsao<?php echo $pedido['id']; ?>" value="<?php echo $pedido['previsao'] ?> " disabled><i style="padding-left: 5px;     padding-right: 5px; cursor: pointer;" class="fa fa-pencil" onclick="edit(this)"></i>-->
                                                    </div>
                                                    <div class="col-md-1 pull-right">
                                                        <a target="_blank" href="https://sistemasdeensino.mackenzie.br/pedidos/relatorio/impressao.php?certifiedKey=<?php echo betoCrypt($pedido['id'],'e'); ?>"><button class="botaoVisualizar" >Visualizar</button></a>
                                                    </div>

                                                    <div class="col-md-1 pull-right">
                                                        <button class="botaoSalvar" onclick="salvarPedido(<?php echo $pedido['id']; ?>,this)">Salvar</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php } ?>
                                    <!-- FINAL POPULANDO COM PHP -->


                                    </tbody>

                                </table>



            </div>
        </div>
    </div>

</div>
    <img src onerror='tirarLoading()'>
    <!--<button onclick=" enviarLoteFn('179',this);">enviar</button>-->

<!-- DataTables -->
<script src="../vendors/datatables/jquery.dataTables.js"></script>
<script src="../vendors/datatables/dataTables.bootstrap4.js"></script>

<script src="../build/js/gerenciarPedidos.js"></script>

<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/moment/locale/pt-br.js"></script>




<script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <script>

        function tirarLoading() {
            document.getElementById("loading").style.display = "none";
        }

        $('.previsao').mask('00/00/0000');

        $(function () {
            $('.datepicker').datetimepicker({
                locale: 'pt-br',
                format: 'DD/MM/YYYY'
            });
        });

        $("#dropBusca li a").click(function(e){

            e.preventDefault();

            titulo = document.getElementById('tituloBusca');

            titulo.setAttribute('data',$(this).attr('id'));

            titulo.innerHTML = $(this).text()+' <span class="caret"></span>';

        });



        $('#filtro-nome').keyup(function() {
            var nomeFiltro = $(this).val().toLowerCase();
            console.log(nomeFiltro);
            $('table tbody').find('tr').each(function() {

                var coluna = document.getElementById('tituloBusca').getAttribute('data');
                //var coluna = 'n';

                var conteudoCelula = $(this).find('td:nth-child('+coluna+')').text();
                //console.log(conteudoCelula);
                var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
                $(this).css('display', corresponde ? '' : 'none');
            });
        });


        function edit(d){

            var input = d.previousElementSibling;

            input.removeAttribute("disabled");
            input.style.backgroundColor = '#f3f1f1';
            input.focus();
            input.style.border = 'border: 1px solid #6cd166';

        }


        $("#dropStatus li a").click(function(e){

            e.preventDefault();

            //alert('oi');

            var status = $(this).attr('status');

            var cor = ['statusRed','statusOrange','statusYellow','statusBlue','statusPurple','statusGreen','statusSilver'];

            var li = $(this)[0].parentElement;
            var ul = li.parentElement;

            var titulo = ul.previousElementSibling;
            //console.log(titulo.innerText);
            //var ul = li.previousElementSibling;
            //alert(ul.text());
            //var titulo = ul.previousSibling;

            //alert(titulo.text());
           //document.getElementById('dropTitulo').innerHTML = '<div class="'+cor[status]+'" ></div>'+$(this).text()+' <span class="caret"></span>';

            if (status == '99'){
                titulo.innerHTML = '<div class="'+cor[6]+'" ></div>'+$(this).text()+' <span class="caret"></span>';
                titulo.setAttribute('data',status);
            }else{
                titulo.innerHTML = '<div class="'+cor[status-1]+'" ></div>'+$(this).text()+' <span class="caret"></span>';
                titulo.setAttribute('data',status);
            }
           //document.getElementById('boxSerie').setAttribute('escolhido',$(this).text());



        });


        function expandir(d) {

            d = d.parentElement;
            //$(d).find('span').text(function(_, value){return value=='-'?'+':'-'});

            var linha = $(d).children("td").eq(0);

            if (linha.children("div").eq(0).hasClass('glyphicon glyphicon-chevron-right')) {
                linha.children("div").eq(0).attr('class', 'glyphicon glyphicon-chevron-down');
            }else{
                linha.children("div").eq(0).attr('class', 'glyphicon glyphicon-chevron-right');
            }



            $(d).nextUntil('tr.headert').slideToggle(100, function(){
            });

        }



        $(document).ready(function() {
            //carregaPedidos();
            document.getElementById("loading").style.display = "unset";
            AtualizaServicos();


        });

        function abrirPaginaExt(d) {

            var pagina = d.getAttribute('data');
            //alert('oe');
            //e.preventDefault();

            $("#main").load( ""+pagina+"#main");
            var modalback = document.querySelectorAll(".modal-backdrop");

            for (i = 0; i < modalback.length; i++) {
                modalback[i].style.display = "none";
            }

        }


        function cancelaPedido(id) {

            var heading = 'Confirmação de Cancelamento';
            var question = 'Deseja realmente cancelar esse pedido ?';
            var cancelButtonTxt = 'Voltar';
            var okButtonTxt = 'Cancelar';

            var callback = function() {

                cancelar(id);

                table = $('#datatablePedidos').DataTable();

                table.ajax.reload();

                $.notify({
                    title: '<strong>Cancelado!</strong>',
                    message: '<br>Pedido Cancelado com Sucesso!'
                },{
                    type: 'success',
                    placement: {
                        from: "top"
                    },
                    offset: {
                        x: 0,
                        y: 100
                    }
                });
            };

            confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

        }

        function cancelar(id) {

            data = {id:id};

            $.ajax({
                type: "POST",
                url: 'controllers/controlerPedidos.php?tipo=cancelaPedido',
                data: data,
                datatype: 'json',
                success: function (data) {
                    //console.log(data);
                    //var usuario = JSON.parse(data);
                    //console.log(usuario);
                    //document.getElementById('inputEmail').value = usuario["email"];
                    //document.getElementById('inputTelefone').value = usuario["telefone"];

                }

            });
        }



        function enviarLote(id,d,categoria) {

            var heading = 'Reenvio de Lote';
            var question = 'Deseja realmente reenviar o lote para o Oracle ?';
            var cancelButtonTxt = 'Voltar';
            var okButtonTxt = 'Reenviar';

            var callback = function() {

                enviarLoteFn(id,d,categoria);


            };

            confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

        }

        function enviarLoteFn(id,d,categoria) {

            data = {id: id};

            $.ajax({
                type: "POST",
                url: 'controllers/controlerPedidos.php?tipo=enviarLote&categoria='+categoria,
                data: data,
                datatype: 'json',
                success: function (data) {
                    //console.log(data.substring(1, 7));
                    if (data.substring(1, 7) != 'Notice') {

                        table = $('#datatablePedidos').DataTable();
                        table.ajax.reload();
                        //table.ajax.reload();
                        d.innerHTML = 'Enviado';
                        d.disabled = true;

                        $.notify({
                            title: '<strong>Reenviado!</strong>',
                            message: '<br>Lote enviado com Sucesso!'
                        }, {
                            type: 'success',
                            placement: {
                                from: "top"
                            },
                            offset: {
                                x: 0,
                                y: 100
                            }
                        });

                    } else {

                        $.notify({
                            title: '<strong>Erro</strong>',
                            message: '<br>Problemas ao reenviar o lote'
                        }, {
                            type: 'danger',
                            placement: {
                                from: "top"
                            },
                            offset: {
                                x: 0,
                                y: 100
                            }
                        });

                    }


                }

            });
        }


            function salvarPedido(id,d) {

                var heading = 'Salvar informações';
                var question = 'Deseja salvar as informações?';
                var cancelButtonTxt = 'Voltar';
                var okButtonTxt = 'Salvar';

                var callback = function() {

                    salvarP(id,d);


                };

                confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

            }

            function retornaClassStatus(texto){

                if(texto == ' Em Processamento '){
                    return 'statusRed';
                }else if (texto == ' Pedido Recebido '){
                    return 'statusOrange';
                }else if (texto == ' Em Análise '){
                    return 'statusYellow';
                }else if (texto == ' Em Separação '){
                    return 'statusBlue';
                }else if (texto == ' Enviado '){
                    return 'statusPurple';
                }else if (texto == ' Concluído '){
                    return 'statusGreen';
                }else if (texto == ' Cancelado '){
                    return 'statusSilver';
                }

            }

            function salvarP(id,d) {

                var cod_oracle = document.getElementById('oracle'+id).value;
                var nf = document.getElementById('nf'+id).value;
                var previsao = document.getElementById('previsao'+id).value;
                var status = document.getElementById('status'+id).getAttribute('data');

                data = {id:id,cod_oracle:cod_oracle,nf:nf,previsao:previsao,status:status};
                //console.log(data);

                if(document.getElementById('status'+id).innerText == ' Em Separação '){
                        //if(document.getElementById('status'+id).innerText != '')
                }

                $.ajax({
                    type: "POST",
                    url: 'controllers/controlerPedidos.php?tipo=salvarPedido',
                    data: data,
                    datatype: 'json',
                    success: function (data) {
                        //console.log(data.substring(1, 7));
                        console.log(data);
                        if (data == 'ok'){

                            //table.ajax.reload();
                            //d.innerHTML = 'Enviado';
                            //d.disabled = true;

                            //Muda status do dropbox
                            document.getElementById('pedidoStatusNome'+id).innerText =  document.getElementById('status'+id).innerText;
                            document.getElementById('pedidoStatus'+id).className = retornaClassStatus(document.getElementById('status'+id).innerText);

                            $.notify({
                                title: '<strong>Enviado!</strong>',
                                message: '<br>Informações salvas com Sucesso!'
                            },{
                                type: 'success',
                                placement: {
                                    from: "top"
                                },
                                offset: {
                                    x: 0,
                                    y: 100
                                }
                            });

                        }else{

                            $.notify({
                                title: '<strong>Erro</strong>',
                                message: '<br>Problemas ao salvar informação!'
                            },{
                                type: 'danger',
                                placement: {
                                    from: "top"
                                },
                                offset: {
                                    x: 0,
                                    y: 100
                                }
                            });

                        }


                    }

                });

        }



        function atualizaStatus(cod_proc,status) {

            data = {cod_proc:cod_proc,status:status};
            //console.log(data);
            //alert('foi');
            $.ajax({
                type: "POST",
                url: 'controllers/controlerPedidos.php?tipo=atualizaStatus',
                data: data,
                datatype: 'json',
                success: function (data) {
                    result = jQuery.parseJSON(data);
                    //console.log(result);

                    document.getElementById('s'+result.cod).innerHTML = '<div class="glyphicon glyphicon glyphicon-ok" style="color: #00547f;font-size: small;">';
                }

            });

        }



        function AtualizaServicos() {

            var i;
            for (i = 0; i < pedidos.length; i++) {
                atualizaStatus(pedidos[i],statuspedidos[i]);
            }

        }


        ////////////////////////////// Funcoes extras ////////////////////

        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("datatablePedidos");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                console.log(rows);
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[0];
                    y = rows[i + 1].getElementsByTagName("TD")[0];
                    //check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

    </script>

