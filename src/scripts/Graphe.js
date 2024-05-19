// Supposons que vous ayez vos données dans une variable appelée 'data'
var data = {
    nodes: [
        { data: { id: 'n1', name: 'Publication 1' } },
        { data: { id: 'n2', name: 'Publication 2' } },
        // Ajoutez plus de noeuds selon vos données
    ],
    edges: [
        { data: { id: 'e1', source: 'n1', target: 'n2' } },
        // Ajoutez plus d'arêtes selon vos données
    ]
};

var cy = cytoscape({
    container: document.getElementById('cy'), // id de l'élément HTML où le graphe sera affiché

    elements: data,

    style: [ // le style des noeuds et des arêtes
        {
            selector: 'node',
            style: {
                'background-color': '#666',
                'label': 'data(name)'
            }
        },
        {
            selector: 'edge',
            style: {
                'width': 3,
                'line-color': '#ccc',
                'target-arrow-color': '#ccc',
                'target-arrow-shape': 'triangle'
            }
        }
    ],

    layout: {
        name: 'grid',
        rows: 1
    }
});