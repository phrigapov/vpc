<?php
?>
<div class="main">

    <div class="col-md-12">
        <button class="menu" data="dashboard/analise.php" onclick="abrirPaginaExt(this)">Recarregar</button>


        <div class="row">
            <table id="acessoPerfil" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Perfil</th>
                    <th>Agosto</th>
                    <th>Setembro</th>
                    <th>Outubro</th>
                    <th>Novembro</th>
                    <th>Dezembro</th>
                    <th>Janeiro</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Professor</td>
                    <td>0001</td>
                    <td>0002</td>
                    <td>0003</td>
                    <td>0004</td>
                    <td>0005</td>
                    <td>0006</td>
                </tr>
                </tbody>
            </table>
        </div>


        <div class="row">
            <div class="col-md-12">

                <div id="acesso_total" style="width: 100%; height: 500px"></div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div id="acessoSegmentado" style="width: 100%; height: 500px"></div>

            </div>

        </div>

        <div class="row">

        <div class="col-md-12">
            <div id="pizzaAtividades" style="width: 100%; height: 500px"></div>
        </div>

        </div>
        <!--
                <div class="row">

                    <div class="col-md-12">
                        <div id="grantAtividade" style="width: 100%; height: 500px"></div>
                    </div>

                </div>
                -->
        <!--
        <div class="row">

            <div class="col-md-12">
                <div id="mapa" style="width: 100%; "></div>
            </div>

        </div>
        -->



    </div>





</div>
<style>
    #lottieold{
        background-color:#fff;
        width:25%;
        height:25%;
        display:block;
        overflow: hidden;
        transform: translate3d(0,0,0);
        text-align: center;
        opacity: 1;
    }
</style>
<div id="lottieold"></div>
<!--<script type="text/javascript" src="vendors/lottie/lottie.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.9/lottie.min.js"></script>
<script src="vendors/lottie/loading2.js"></script>


<link rel="stylesheet" href="vendors/datatables/dataTables.bootstrap4.css">

<script src="vendors/datatables/jquery.dataTables.js"></script>
<script src="vendors/datatables/dataTables.bootstrap4.js"></script>



    <script type="text/javascript">

    $(document).ready(function() {
        carregaAcessoPerfil();
        //document.getElementById("loading").style.display = "unset";

    });



    google.charts.load('current', {'packages':['corechart']});
    google.charts.load('current', {'packages':['gantt']});

    google.charts.load('current', {
        'packages': ['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyAk4UqBrYMnQiDfLnhgGfPS1PmpiQVqx20'
    });

    google.charts.setOnLoadCallback(drawChartAcessoTotal);
    google.charts.setOnLoadCallback(drawAcessoSegmentado);
    google.charts.setOnLoadCallback(drawChartPizzaAtividades);
    google.charts.setOnLoadCallback(drawGrantAtividade);
    google.charts.setOnLoadCallback(drawMapa);

    function drawChartAcessoTotal() {
        var jsonData = $.ajax({
            url: "dashboard/data.php?tipo=acesso_total",
            dataType: "json",
            async: false
        }).responseText;

        //console.log(jsonData);

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);


        var options = {
            title: 'Tráfego de acessos totais',
            hAxis: {title: 'Meses',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            pointSize: 10
        };

        var chart = new google.visualization.AreaChart(document.getElementById('acesso_total'));
        chart.draw(data, options);
    }

    function drawAcessoSegmentado() {
        var jsonData = $.ajax({
            url: "dashboard/data.php?tipo=acessoSegmentado",
            dataType: "json",
            async: false
        }).responseText;

        //console.log(jsonData);

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);


        var options = {
            title: 'Acessos únicos segmentados',
            hAxis: {title: 'Dias',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            pointSize: 10
        };

        var chart = new google.visualization.AreaChart(document.getElementById('acessoSegmentado'));
        chart.draw(data, options);
        //print_r(data);
    }


    function drawChartPizzaAtividades() {

        var jsonData = $.ajax({
            url: "dashboard/data.php?tipo=pizzaAtividades",
            dataType: "json",
            async: false
        }).responseText;

        console.log(jsonData);

        var data = new google.visualization.DataTable(jsonData);

        var options = {
            title: 'Porcentagem de uso das atividades',
            pieSliceText: 'value-and-percentage',
            legend: {position: 'labeled', textStyle: {color: 'black', fontSize: 14}},
            fontSize: '10',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('pizzaAtividades'));
        chart.draw(data, options);
    }


    function toMilliseconds(minutes) {
        return minutes * 60 * 1000;
    }

    function drawGrantAtividade() {
        /*
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        data.addRows([
            ['bncc', 'BNCC', 'spring',
                new Date(2014, 2, 22), new Date(2014, 5, 20), null, 70, null],
            ['2014Summer', 'Método Fônico', 'summer',
                new Date(2014, 5, 21), new Date(2014, 8, 20), null, 100, null],
            ['2014Autumn', '10 Razões', 'autumn',
                new Date(2014, 8, 21), new Date(2014, 11, 20), null, 100, null],
            ['2014Winter', 'Cosmovisão', 'winter',
                new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null]
        ]);
        */

        var jsonData = $.ajax({
            url: "dashboard/data.php?tipo=grantAtividade",
            dataType: "json",
            async: false
        }).responseText;


        var data = new google.visualization.DataTable(jsonData);

        var options = {
            height: 400,
            gantt: {
                trackHeight: 30
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('grantAtividade'));
        chart.draw(data, options);
    }


    function drawMapa() {
        var data = google.visualization.arrayToDataTable([
            ['Country',   'Population', 'Area Percentage'],
            ['France',  65700000, 50],
            ['Germany', 81890000, 27],
            ['Poland',  38540000, 23]
        ]);

        var options = {
            sizeAxis: { minValue: 0, maxValue: 100 },
            region: '155', // Western Europe
            displayMode: 'markers',
            colorAxis: {colors: ['#e7711c', '#4374e0']} // orange to blue
        };

        var chart = new google.visualization.GeoChart(document.getElementById('mapa'));
        chart.draw(data, options);

    };



    function abrirPaginaExt(d) {

        var pagina = d.getAttribute('data');
        //alert('oe');
        //e.preventDefault();

        $("#main").load( ""+pagina+"#main");

    }

    function carregaAcessoPerfil() {

        $('#acessoPerfil').DataTable({
            "paging": true,
            "bDestroy": true,
            "iDisplayLength": 10,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": false,
            "ajax": "dashboard/controlerData.php?tipo=acessoPerfil",
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

    }

</script>
