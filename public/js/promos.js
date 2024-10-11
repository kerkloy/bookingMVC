$(document).ready(function() {
    var promosTable = $('#tablePromo').DataTable({
        info: false,
        paging: false,
        searching: false,
        dom: 'Bfrtip',
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
                    window.location = 'promos/create'; // Navigate to the new promo creation page
                } 
            },
        ],
        "ajax": function(data, callback, settings){
            axios.get('/get-promos')
            .then(function(response) {
                console.log(response.data);

                var promos = response.data.map(function(promos){
                    return {
                        PromoID: promos.promo_id,
                        Title: promos.promo_header,
                        PromoCreated: promos.latest_created_at,
                        Action: '<button class="btn btn-primary btn-sm editPromo" data-id="' + promos.promo_id + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm deletePromo" data-id="' + promos.promo_id + '">Delete</button>'
                    };
                });
                callback({
                    data: promos
                });
            })
            .catch(function(error) {
                console.error('Error fetching promos:', error);
            });
        },
        "columns": [
            { data: 'PromoID', title: "PromoID"},
            { data: 'Title', title: "Title" },
            { data:'PromoCreated', title: "Promo Created" },
            { data:'Action', title: "Action"}
        ],
    });


    $('#tablePromo').on('click', '.editPromo', function() {
        var promoId = $(this).data('id');

        window.location = 'promos/' + promoId; 
    });
});