<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./src/styles/Graphe.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <title>PolyRecherche - Graphe</title>
</head>

<body style="background-color:gainsboro;">
    <?php require_once("./src/components/header.php"); ?>
    <main>
        <section id="titre" class="text-center text-white p-4" style="background-color: #0a4275;">
            <h1>Graphe de citation</h1>
        </section>
        <section id="image" class="text-center">
            <img src="assets/graphe2.png" alt="Exemple de graphe">
        </section>
        <section>
            <h2>Introduction du sujet</h2>
            <p>Dans le monde dynamique de la recherche, il est crucial de pouvoir suivre l'évolution des travaux et identifier les tendances émergentes. Notre projet de groupe sur les graphes de citations offre aux enseignants-chercheurs un outil puissant pour visualiser l'impact de leur recherche et explorer les liens entre les publications.</p>
        </section>
        <section>
            <h2>Problème</h2>
            <p>Le suivi traditionnel de la recherche, basé uniquement sur le nombre de publications, ne fournit pas une image complète de l'impact d'un chercheur. Les graphes de citations, en revanche, permettent de visualiser les relations entre les publications et de mesurer l'influence d'un travail sur le domaine de recherche.</p>
        </section>
        <section>
            <h2>Solution</h2>

            <p>Notre projet propose une plateforme innovante qui offre aux enseignants-chercheurs les fonctionnalités suivantes :</p>

            <ul>
                <li><strong>Récupération automatique de publications:</strong> Récupérez automatiquement vos publications à partir de bases de données telles que Google Scholar et HAL.</li>
                <li><strong>Visualisation des graphes de citations:</strong> Construisez des graphes de citations pour visualiser les liens entre vos publications et celles d'autres chercheurs.</li>
                <li><strong>Suivi de l'évolution de la recherche:</strong> Suivez l'évolution de votre recherche dans le temps et identifiez les tendances émergentes.</li>
            </ul>


        </section>
        <div id="container">
            <div id="graph"></div>
            <div id="publication-info">Clique sur un noeud pour avoir plus d'information</div>
        </div>

        <script>
            <?php
            $sql = 'SELECT pub.title AS titre_publication, b.title AS titre_cite , pub.publication_date AS date_publication , b.publication_date AS date_cite, author.firstname AS firstname ,author.lastname AS lastname FROM `2025_quotes` JOIN `2025_publications` pub ON `2025_quotes`.id_publication = pub.id JOIN `2025_publications` b ON `2025_quotes`.id_quote = b.id JOIN `2025_publish` liaison ON `2025_quotes`.id_publication = liaison.id_publication JOIN `2025_authors` author ON liaison.id_author = author.id    ';
            $result1 = mysqli_query($conn, $sql);
            $citations = [];
            while ($row = mysqli_fetch_assoc($result1)) {
                $citations[] = [
                    'source' => $row['titre_publication'],
                    'source_date' => $row['date_publication'],
                    'source_author_firstname' => $row['firstname'],
                    'source_author_lastname' => $row['lastname'],
                    'target' => $row['titre_cite'],
                    'target_date' => $row['date_cite']
                ];
            }
            $citations_json = json_encode($citations);
            ?>
            var citations = <?php echo $citations_json; ?>;
            var nodes = {};

            citations.forEach(function(link) {
                if (!nodes[link.source]) {
                    nodes[link.source] = {
                        name: link.source,
                        data: link
                    };
                }
                if (!nodes[link.target]) {
                    nodes[link.target] = {
                        name: link.target,
                        data: link
                    };
                }
                link.source = nodes[link.source];
                link.target = nodes[link.target];
            });

            var width = 600,
                height = 600;

            var svg = d3.select("#graph").append("svg")
                .attr("width", width)
                .attr("height", height)
                .style("margin", "0 auto")
                .style("display", "block")
                .style("background-color", "white");

            // Define arrow markers for graph links
            svg.append('defs').append('marker')
                .attr('id', 'arrowhead')
                .attr('viewBox', '-0 -5 10 10')
                .attr('refX', 13)
                .attr('refY', 0)
                .attr('orient', 'auto')
                .attr('markerWidth', 13)
                .attr('markerHeight', 13)
                .attr('xoverflow', 'visible')
                .append('svg:path')
                .attr('d', 'M 0,-5 L 10 ,0 L 0,5')
                .attr('fill', '#999')
                .style('stroke', 'none');

            var simulation = d3.forceSimulation()
                .nodes(d3.values(nodes))
                .force("link", d3.forceLink(citations).distance(60).id(function(d) {
                    return d.name;
                }))
                .force("charge", d3.forceManyBody().strength(-300))
                .force("center", d3.forceCenter(width / 2, height / 2))
                .on("tick", tick);

            var link = svg.selectAll(".link")
                .data(citations)
                .enter().append("line")
                .attr("class", "link")
                .attr("marker-end", "url(#arrowhead)")
                .style("stroke", "#999")
                .style("stroke-width", "0.5px");

            var node = svg.selectAll(".node")
                .data(simulation.nodes())
                .enter().append("circle")
                .attr("class", "node")
                .attr("r", 5)
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
                    // Afficher le nom complet de la publication dans une div à côté du graphe 
                    var publicationInfo = document.getElementById("publication-info");
                    publicationInfo.innerHTML = "<h3>Publication Information:</h3>" +
                        "<p><b>Titre :</b> " + d.name + "<br>" +
                        "<b>Date :</b> " + d.data.source_date + "<br>" +
                        "<b>Auteurs :</b> " + d.data.source_author_firstname + " " + d.data.source_author_lastname + "<br><br></p>";
                });

            function tick() {
                link.attr("x1", function(d) {
                        return d.source.x;
                    })
                    .attr("y1", function(d) {
                        return d.source.y;
                    })
                    .attr("x2", function(d) {
                        return d.target.x;
                    })
                    .attr("y2", function(d) {
                        return d.target.y;
                    });

                node.attr("cx", function(d) {
                        return d.x;
                    })
                    .attr("cy", function(d) {
                        return d.y;
                    });
            }
        </script>
    </main>
    <?php require_once("./src/components/footer.php"); ?>
</body>

</html>