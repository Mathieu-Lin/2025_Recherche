<?php
$_SESSION['page'] = 3;
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://d3js.org/d3.v4.min.js"></script>
</head>
<body>
    <script>
        // Données de citation
        var citations = [
            {source: "Publication 1", target: "Publication 2"},
            {source: "Publication 2", target: "Publication 3"},
            // Ajoutez plus de citations ici
        ];

        // Créer un dictionnaire des noeuds
        var nodes = {};

        // Convertir les liens en objets de noeuds
        citations.forEach(function(link) {
            link.source = nodes[link.source] || (nodes[link.source] = {name: link.source});
            link.target = nodes[link.target] || (nodes[link.target] = {name: link.target});
        });

        var width = 800, height = 600;

        var svg = d3.select("body").append("svg")
            .attr("width", width)
            .attr("height", height);

        var simulation = d3.forceSimulation()
            .nodes(d3.values(nodes))
            .force("link", d3.forceLink(citations).distance(60))
            .force("charge", d3.forceManyBody().strength(-300))
            .force("center", d3.forceCenter(width / 2, height / 2))
            .on("tick", tick);

        var link = svg.selectAll(".link")
            .data(citations)
            .enter().append("line")
            .attr("class", "link");

        var node = svg.selectAll(".node")
            .data(simulation.nodes())
            .enter().append("circle")
            .attr("class", "node")
            .attr("r", 5);  // Rayon du cercle

        // Mise à jour de la position des noeuds et des liens
        function tick() {
            link.attr("x1", function(d) { return d.source.x; })
                .attr("y1", function(d) { return d.source.y; })
                .attr("x2", function(d) { return d.target.x; })
                .attr("y2", function(d) { return d.target.y; });

            node.attr("cx", function(d) { return d.x; })
                .attr("cy", function(d) { return d.y; });
        }
    </script>
</body>
</html>
