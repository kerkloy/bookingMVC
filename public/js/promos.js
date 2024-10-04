$(document).ready(function() {
    var promosTable = $('#tablePromo').DataTable({
        info: false,
        paging: false,
        searching: false,
        buttons: [
            {
                text: 'Reload',
                action: function(e, dt, node, config) {
                    $('#tablePromo').DataTable().ajax.reload(); // Ensure the correct table ID is used
                } 
            },
            {
                text: 'New',
                action: function(e, dt, node, config) {
                    window.location = 'createpo.html'; // Navigate to the new promo creation page
                } 
            },
        ],
        // "ajax": {
        //     "url": "/promos",
        //     "type": "GET",
        //     "dataSrc": function (json) {
        //         return json.data;
        //     }
        // },
        "columns": [
            { title: "PromoID"},
            { title: "Title" },
            { title: "Action", render: function(data, type, row) {
                return '<button class="btn btn-primary btn-sm editPromo" data-id="' + row[0] + '">Edit</button> ' +
                       '<button class="btn btn-danger btn-sm deletePromo" data-id="' + row[0] + '">Delete</button>';
            }}
        ],
    });
});