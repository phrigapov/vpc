data = [{
        "dia": 1,
        "janeiro": 2,
        "fevereiro": 5,
        "março": 13
    },
    {
        "dia": 2,
        "janeiro": 3,
        "fevereiro": 4,
        "março": 14
    },
    {
        "dia": 3,
        "janeiro": 1,
        "fevereiro": 4,
        "março": 16
    },
    {
        "dia": 4,
        "janeiro": 7,
        "fevereiro": 4,
        "março": 12
    },
    {
        "dia": 5,
        "janeiro": 8,
        "fevereiro": 8,
        "março": 7
    },
    {
        "dia": 6,
        "janeiro": 8,
        "fevereiro": 13,
        "março": 9
    },
    {
        "dia": 7,
        "janeiro": 5,
        "fevereiro": 15,
        "março": 3
    },
    {
        "dia": 8,
        "janeiro": 4,
        "fevereiro": 17,
        "março": 2
    },
    {
        "dia": 9,
        "janeiro": 9,
        "fevereiro": 18,
        "março": 1
    },
    {
        "dia": 10,
        "janeiro": 11,
        "fevereiro": 13,
        "março": 1
    }
];


// set the dimensions and margins of the graph
const heightValue = 400;
const widthValue = 700;

// append the svg object to the body of the page
var svg = d3.select("#my_dataviz")
    .append("svg")
    .attr("viewBox", `-40 -20 ${widthValue} ${heightValue}`);


const strokeWidth = 1.5;
const margin = { top: 0, bottom: 20, left: 30, right: 20 };

const chart = svg.append("g").attr("transform", `translate(${margin.left},0)`);
const width = 600 - margin.left - margin.right - (strokeWidth * 2);
const height = 300 - margin.top - margin.bottom;
const grp = chart
    .append("g")
    .attr("transform", `translate(-${margin.left - strokeWidth},-${margin.top})`);
//Read the data



// List of groups (here I have one group per column)
var allGroup = ["janeiro", "fevereiro", "março"]

// add the options to the button
d3.select("#selectButton")
    .selectAll('myOptions')
    .data(allGroup)
    .enter()
    .append('option')
    .text(function(d) { return d; }) // text showed in the menu
    .attr("value", function(d) { return d; }) // corresponding value returned by the button

// Add X axis --> it is a date format
var x = d3.scaleLinear()
    .domain([0, 31])
    .range([0, width]);
svg.append("g")
    .attr("transform", "translate(0," + height + ")")
    .call(d3.axisBottom(x));

// Add Y axis
var y = d3.scaleLinear()
    .domain([0, 200])
    .range([height, 0]);
svg.append("g")
    .call(d3.axisLeft(y));

// Initialize line with group a
var line = svg
    .append('g')
    .append("path")
    .datum(data)
    .attr("d", d3.line()
        .x(function(d) { return x(+d.dia) })
        .y(function(d) { return y(+d.janeiro) })
    )
    .attr("stroke", "black")
    .style("stroke-width", 2)
    .style("fill", "none");

// Initialize dots with group a
var dot = svg
    .selectAll('circle')
    .data(data)
    .enter()
    .append('circle')
    .attr("cx", function(d) { return x(+d.dia) })
    .attr("cy", function(d) { return y(+d.janeiro) })
    .attr("r", 5)
    .style("fill", "#69b3a2");


var texto = svg.selectAll("label")
    .data(data).enter()
    .append("text")
    // Add your code below this line
    .attr("x", function(d) { return x(+d.dia) - 5 })
    .attr("y", function(d) { return y(+d.janeiro) - 10 })
    .text(function(d) { return (d.janeiro) })
    .attr("font-size", "12px");

svg
    .append('circle')
    .attr("cx", width + 10)
    .attr("cy", 50)
    .attr("r", 5)
    .style("fill", "#69b3a2");

svg
    .append("text")
    .attr("x", width + 20)
    .attr("y", 54) // +20 to adjust position (lower)
    .text("Tráfego por dia")
    .attr("font-size", "12px")
    .attr("fill", "grey")

svg
    .append("text")
    .attr("x", 230)
    .attr("y", 14) // +20 to adjust position (lower)
    .text("Tráfego Total")
    .attr("font-size", "19px")
    .attr("fill", "grey")

svg
    .append("text")
    .attr("x", 250)
    .attr("y", height + 30) // +20 to adjust position (lower)
    .text("Dias")
    .attr("font-size", "12px")
    .attr("fill", "grey")

svg
    .append("text")
    .attr("x", -150)
    .attr("y", -30) // +20 to adjust position (lower)
    .attr("transform", "rotate(-90)")
    .text("Tráfego")
    .attr("font-size", "12px")
    .attr("fill", "grey")


// A function that update the chart
function update(selectedGroup) {

    // Create new data with the selection?
    var dataFilter = data.map(function(d) { return { dia: d.dia, value: d[selectedGroup] } })

    // Give these new data to update line
    line
        .datum(dataFilter)
        .transition()
        .duration(1000)
        .attr("d", d3.line()
            .x(function(d) { return x(+d.dia) })
            .y(function(d) { return y(+d.value) })
        )
    dot
        .data(dataFilter)
        .transition()
        .duration(1000)
        .attr("cx", function(d) { return x(+d.dia) })
        .attr("cy", function(d) { return y(+d.value) })

    texto
        .data(dataFilter)
        .transition()
        .duration(1000)
        .attr("x", function(d) { return x(+d.dia) - 5 })
        .attr("y", function(d) { return y(+d.value) - 10 })
        .text(function(d) { return (d.value) })
}

// When the button is changed, run the updateChart function
d3.select("#selectButton").on("change", function(d) {
    // recover the option that has been chosen
    var selectedOption = d3.select(this).property("value")
        // run the updateChart function with this selected option
    update(selectedOption)
})