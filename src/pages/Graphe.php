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
        <?php
        $sql = 'SELECT pub.title AS titre_publication, b.title AS titre_cite FROM `2025_quotes` JOIN `2025_publications` pub ON `2025_quotes`.id_publication = pub.id JOIN `2025_publications` b ON `2025_quotes`.id_quote = b.id';

        // Exécution de la requête SQL
        $result1 = mysqli_query($conn, $sql);
        
        // Récupération des résultats
        $citations = [];
        while ($row = mysqli_fetch_assoc($result1)) {
            $citations[] = ['source' => $row['titre_publication'], 'target' => $row['titre_cite']];
        }
        
        // Convertir le tableau PHP en JSON pour l'utiliser en JavaScript
        $citations_json = json_encode($citations);
        ?>
        // Données de citation
        var citations = <?php echo $citations_json; ?>;

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
            .attr("class", "link")
            .style("stroke", "#999")  // Couleur des liens
            .style("stroke-width", "2px");  // Épaisseur des liens

        var node = svg.selectAll(".node")
            .data(simulation.nodes())
            .enter().append("circle")
            .attr("class", "node")
            .attr("r", 5)  // Rayon du cercle
            .on("mouseover", function(d) {
                // Afficher le nom du titre lorsque la souris passe sur le nœud
                svg.append("text")
                    .attr("id", "tooltip")
                    .attr("x", d.x)
                    .attr("y", d.y)
                    .text(d.name);
            })
            .on("mouseout", function(d) {
                // Enlever le nom du titre lorsque la souris quitte le nœud
                d3.select("#tooltip").remove();
            })
            .on("click", function(d) {
                // Action à effectuer lorsque le nœud est cliqué
                alert("Vous avez cliqué sur : " + d.name);
            });

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
