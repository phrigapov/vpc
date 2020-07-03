buscaDados();

var dados =  [
    { data: '1-03-20', qtd: 513, qtd2: 300, qtd3: 100},
    { data: '2-03-20', qtd: 580, qtd2: 250, qtd3: 200},
    { data: '3-03-20', qtd: 420, qtd2: 402, qtd3: 100},
    { data: '4-03-20', qtd: 402, qtd2: 520, qtd3: 300},
    { data: '5-03-20', qtd: 312, qtd2: 600, qtd3: 400},
    { data: '6-03-20', qtd: 100, qtd2: 320, qtd3: 500},
    { data: '7-03-20', qtd: 150, qtd2: 200, qtd3: 100},
    { data: '8-03-20', qtd: 113, qtd2: 220, qtd3: 100},
    { data: '9-03-20', qtd: 153, qtd2: 400, qtd3: 100},
    { data: '10-03-20', qtd: 302, qtd2: 600, qtd3: 400},
    { data: '11-03-20', qtd: 420, qtd2: 701, qtd3: 100},
    { data: '12-03-20', qtd: 305, qtd2: 600, qtd3: 300},
    { data: '13-03-20', qtd: 410, qtd2: 400, qtd3: 100},
    { data: '14-03-20', qtd: 221, qtd2: 550, qtd3: 200},
    { data: '15-03-20', qtd: 222, qtd2: 420, qtd3: 100},
    { data: '16-03-20', qtd: 320, qtd2: 600, qtd3: 100},
    { data: '17-03-20', qtd: 244, qtd2: 501, qtd3: 230},
    { data: '18-03-20', qtd: 321, qtd2: 500, qtd3: 320},
    { data: '19-03-20', qtd: 450, qtd2: 400, qtd3: 340},
    { data: '20-03-20', qtd: 290, qtd2: 560, qtd3: 390},
    { data: '21-03-20', qtd: 222, qtd2: 430, qtd3: 440},
    { data: '22-03-20', qtd: 502, qtd2: 840, qtd3: 470},
    { data: '23-03-20', qtd: 550, qtd2: 920, qtd3: 490},
    { data: '24-03-20', qtd: 620, qtd2: 1010, qtd3: 500},
    { data: '25-03-20', qtd: 742, qtd2: 820, qtd3: 530},
    { data: '26-03-20', qtd: 630, qtd2: 901, qtd3: 520},
    { data: '27-03-20', qtd: 502, qtd2: 1010, qtd3: 550},
    { data: '28-03-20', qtd: 650, qtd2: 801, qtd3: 450},
    { data: '29-03-20', qtd: 433, qtd2: 950, qtd3: 540},
    { data: '30-03-20', qtd: 633, qtd2: 800, qtd3: 460},
    { data: '31-03-20', qtd: 410, qtd2: 730, qtd3: 510}
  ];
  
  
  // set the dimensions and margins of the graph
  var margin = {top: 20, right: 20, bottom: 30, left: 50},
      width = 960 - margin.left - margin.right,
      height = 500 - margin.top - margin.bottom;
  
  // parse the date / time
  
  var parseTime = d3.timeParse("%d-%m-%y");
  
  // set the ranges
  var x = d3.scaleTime().range([0, width]);
  var y = d3.scaleLinear().range([height, 0]);
  
  // define the line
  var valueline = d3.line()
      .x(function(d) { return x(d.data); })
      .y(function(d) { return y(d.qtd); });
  
      // define the 2nd line
  var valueline2 = d3.line()
      .x(function(d) { return x(d.data); })
      .y(function(d) { return y(d.qtd2); });
  
      // define the 3nd line
  var valueline3 = d3.line()
      .x(function(d) { return x(d.data); })
      .y(function(d) { return y(d.qtd3); });
  
  // append the svg obgect to the body of the page
  // appends a 'group' element to 'svg'
  // moves the 'group' element to the top left margin
  var svg = d3.select("#temporal").append("svg")
      .attr("width", width + margin.left + margin.right)
      .attr("height", height + margin.top + margin.bottom)
    .append("g")
      .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");
  
  // Get the data
  
  
    // format the data
    dados.forEach(function(d) {
        d.data = parseTime(d.data);
        d.qtd = +d.qtd;
        d.qtd2 = +d.qtd2;
        d.qtd3 = +d.qtd3;
    });
  
    // Scale the range of the data
    x.domain(d3.extent(dados, function(d) { return d.data; }));
    y.domain([0, d3.max(dados, function(d) { return d.qtd2; })]);
  
    // Add the valueline path.
    svg.append("path")
        .data([dados])
        .attr("class", "lineV")
        .attr("d", valueline);
  
    // Add the valueline2 path.
    svg.append("path")
        .data([dados])
        .attr("class", "lineV")
        .style("stroke", "red")
        .attr("d", valueline2);
  
        // Add the valueline3 path.
    svg.append("path")
        .data([dados])
        .attr("class", "lineV")
        .style("stroke", "green")
        .attr("d", valueline3);
  
    // Add the X Axis
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));
  
    // Add the Y Axis
    svg.append("g")
        .call(d3.axisLeft(y));


    function buscaDados() {

        //data = {cod_proc:cod_proc,status:status};
        id ='';
        data = {id:id};
        $.ajax({
            type: "POST",
            url: 'controlerData.php?tipo=temporal',
            data: data,
            datatype: 'json',
            success: function (data) {
                result = jQuery.parseJSON(data);
                console.log(result);

                //document.getElementById('s'+result.cod).innerHTML = '<div class="glyphicon glyphicon glyphicon-ok" style="color: #00547f;font-size: small;">';
            }

        });

    }

  