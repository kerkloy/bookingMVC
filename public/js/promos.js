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
                        Action: '<button class="btn btn-primary btn-sm editPromo" data-id="' + promos.promo_id + '">Show</button> ' +
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


    $('#tablePromo').on('click', '.deletePromo', function() {
        var promoId = $(this).data('id');
    
        // SweetAlert 1 confirmation dialog
        swal({
            title: 'Are you sure?',
            text: "Do you really want to delete this promo? This action cannot be undone.",
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: false,
                    visible: true,
                    className: "btn btn-secondary"
                },
                confirm: {
                    text: "Yes, delete it!",
                    value: true,
                    visible: true,
                    className: "btn btn-danger"
                }
            },
            dangerMode: true
        }).then((isConfirmed) => {
            if (isConfirmed) {
                // Perform the deletion if confirmed
                axios.delete('/promos/' + promoId)
                    .then(function(response) {
                        // Show success message
                        swal({
                            title: 'Deleted!',
                            text: 'The promo has been deleted.',
                            icon: 'success'
                        });
                        // Reload the DataTable
                        $('#tablePromo').DataTable().ajax.reload();
                    })
                    .catch(function(error) {
                        // Show error message
                        swal({
                            title: 'Error!',
                            text: 'An error occurred while deleting the promo.',
                            icon: 'error'
                        });
                        console.error('Error deleting promo:', error);
                    });
            }
        });
    });
    
    
});