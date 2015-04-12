//Constants for the SVG
  var w = 1200,
      h = 750,
      r = 5,
      padding = 2, //separation b/w nodes
      color = d3.scale.category20();

//Set up the force layout
var force = d3.layout.force()
	.gravity(0.06)
    .charge(-200)
    .linkDistance(40)
    .size([w *= (2/3), h *= (2/3)]);

//Append a SVG to the body of the html page. Assign this SVG as an object to svg
var svg = d3.select("body").append("svg")
    .attr("width", w)
    .attr("height", h);

svg.append("svg:rect")
    .attr("width", w - 2)
    .attr("height", h - 10)
    .style("fill", "#FFF")
    .style("stroke", "#000");
  
//Read the data from the data element 
var data = document.getElementById('data').innerHTML;
graph = JSON.parse(data);

//Creates the graph data structure out of the json data
force.nodes(graph.nodes)
     .links(graph.links)
     .start();

//Create all the line svgs but without locations yet
var link = svg.selectAll(".link")
    .data(graph.links)
    .enter().append("line")
    .attr("class", "link")
    .style("stroke-width", function (d) { return Math.sqrt(d.value); });

var node = svg.selectAll(".node")
    .data(graph.nodes)
    .enter().append("g")
    .attr("class", "node")
    .call(force.drag)
	.on('dblclick', connectedNodes);

node.append("circle")
    .attr("r", function (d) { return r + (d.Betweenness / 200);})
    .style("fill", function (d) { return color(d.group);})
    .style("stroke", function(d) { return d3.rgb(color(d.group)).darker(); });

node.append("text")
      .attr("dx", function (d) { return r + 3 + (d.Betweenness / 200);})
      .attr("dy", ".35em")
      .text(function(d) { return d.label; })
      .style("stroke", "#000")
      .style("stroke-width", "0.5px")
      .style("font", "14px helvetica");

//Toggle stores whether the highlighting is on
var toggle = 0;
//Create an array logging what is connected to what
var linkedByIndex = {};
for (i = 0; i < graph.nodes.length; i++) {
    linkedByIndex[i + "," + i] = 1;
};
graph.links.forEach(function (d) {
    linkedByIndex[d.source.index + "," + d.target.index] = 1;
});
//This function looks up whether a pair are neighbours
function neighboring(a, b) {
    return linkedByIndex[a.index + "," + b.index];
}
function connectedNodes() {
    if (toggle == 0) {
        //Reduce the opacity of all but the neighbouring nodes
        d = d3.select(this).node().__data__;
        node.style("opacity", function (o) {
            return neighboring(d, o) | neighboring(o, d) ? 1 : 0.1;
        });
        link.style("opacity", function (o) {
            return d.index==o.source.index | d.index==o.target.index ? 1 : 0.1;
        });
        //Reduce the op
        toggle = 1;
    } else {
        //Put them back to opacity=1
        node.style("opacity", 1);
        link.style("opacity", 1);
        toggle = 0;
    }
}
  

function collide(alpha) {
  var quadtree = d3.geom.quadtree(graph.nodes);
  return function(d) {
    var rb = 2*r + padding,
        nx1 = d.x - rb,
        nx2 = d.x + rb,
        ny1 = d.y - rb,
        ny2 = d.y + rb;
    quadtree.visit(function(quad, x1, y1, x2, y2) {
      if (quad.point && (quad.point !== d)) {
        var x = d.x - quad.point.x,
            y = d.y - quad.point.y,
            l = Math.sqrt(x * x + y * y);
          if (l < rb) {
          l = (l - rb) / l * alpha;
          d.x -= x *= l;
          d.y -= y *= l;
          quad.point.x += x;
          quad.point.y += y;
        }
      }
      return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
    });
  };
}
  
//Now we are giving the SVGs co-ordinates - the force layout is generating the co-ordinates which this code is using to update the attributes of the SVG elements
force.on("tick", function () {
    link.attr("x1", function (d) { return d.source.x; })
        .attr("y1", function (d) { return d.source.y; })
        .attr("x2", function (d) { return d.target.x; })
        .attr("y2", function (d) { return d.target.y; });    
    d3.selectAll("circle").attr("cx", function (d) { return d.x = Math.max(r, Math.min(w -10 - r, d.x)); })
                          .attr("cy", function (d) { return d.y = Math.max(r, Math.min(h-10 - r, d.y)); })
    d3.selectAll("text").attr("x", function (d) { return d.x; })
                        .attr("y", function (d) { return d.y; });
  node.each(collide(0.5));
});
  
  //Search Functionality
  
var optArray = [];
for (var i = 0; i < graph.nodes.length - 1; i++) {
   optArray.push(graph.nodes[i].label);
}
optArray = optArray.sort();
$(function () {
    $("#phil-search").autocomplete({
        source: optArray
    });
});
function searchNode() {
    //find the node
    var selectedVal = document.getElementById('phil-search').value;
    var node = svg.selectAll(".node");
    if (selectedVal == "none") {
        node.style("stroke", "white").style("stroke-width", "1");
    } else {
        var selected = node.filter(function (d, i) {
            return d.label != selectedVal;
        });
        selected.style("opacity", "0");
        var link = svg.selectAll(".link")
        link.style("opacity", "0");
      
        d3.selectAll(".node, .link").transition()
            .duration(5000)
            .style("opacity", 1);
    }
}
