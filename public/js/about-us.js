$(document).ready(function(){
    var items = [];
    var imgTable = $('#tableUploads').DataTable({
        "info": false,
        "paging": false,
        "searching": false,
        "data": items,
        "columns": [
            { title: "Description" },
            { title: "Image", render: function(data, type, row) {
                return '<img src="'+data+'" style="width: 50px; height: 50px;">';
            }},
            { title: "Action", render: function(data, type, row) {
                return '<button class="btn btn-danger btn-sm deleteItem" data-id="'+row[3]+'">Delete</button>';
            }}
        ],
        "order": [],
    });

    var imageCount = 0;

    async function loadUploadedImages() {
        try {
            const response = await axios.get('/about-us/images');
            if (response.status === 200) {
                items = response.data.map(item => [item.description, item.image_path, '', item.id]);
                imgTable.clear().rows.add(items).draw(); // Populate the table

                imageCount = items.length;
            }
        } catch (error) {
            console.error('Error loading images:', error);
        }
    }
    loadUploadedImages()

    async function loadContent() {
        try {
            const response = await axios.get('/about-us/get-content');
            if (response.status === 200) {
                $('#title').val(response.data[0].aboutHeader);
                $('#abtBody').val(response.data[0].aboutParagraph);
            }
        } catch (error) {
            console.error('Error loading content:', error);
        }
    }
    loadContent();

    // Show modal for adding an item
    $('#addItem').on('click', function() {
        if (imageCount >= 2){
            swal({
                title: "Error",
                text: "You cannot add more than 2 images.",
                icon: "error",
                button: "OK"
            });
            return; 
        }
        else{
            $('#addItemModal').modal('show');
        }
        

    });

    // Handle modal cancel button
    $('.attachmentCancelBtn').on('click', function(){
        $('#imgDesc').val('');
        $('#img').val('');
        $('#addItemModal').modal('hide');
    });

    // Save the item and upload the image
    $('#btnSaveItemModal').on('click', async function() {
        var description = $('#imgDesc').val();
        var title = '';
        var image_path = '';
        
        var fp = $('#img'); // File input element
        var lg = fp[0].files.length; // Length of files
        var attachImg = fp[0].files; // Array of attached files
    
        if (lg > 0) {
            var file = attachImg[0];
            title = file.name;
            image_path = '/uploads/about_us/' + title; // Set your image path
    
            var formData = new FormData();
            formData.append('img', file);
            formData.append('description', description);
            formData.append('title', title);
    
            try {
                const response = await axios.post('/about-us/upload/', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
    
                if (response.status === 200) {
                    var uploadedItem = response.data; // Assuming response contains image data and id
                    var item = [description, image_path, '', uploadedItem.id]; // Store id for deletion
                    
                    items.push(item);
                    imgTable.clear().rows.add(items).draw(); // Update the table
    
                    $('#imgDesc').val('');
                    $('#img').val('');
                    $('#addItemModal').modal('hide');
                    await loadUploadedImages();
                }
            } catch (error) {
                console.error(error);
                alert('Image upload failed.');
            }
        } else {
            alert('Please select an image to upload.');
        }
    });

    // Handle deleting an item
    $('#tableUploads tbody').on('click', '.deleteItem', async function() {
        var itemId = $(this).data('id'); // Get the image ID from the data-id attribute

        try {
            // Send a DELETE request to the server
            const response = await axios.delete('/about-us/delete/' + itemId);
            
            if (response.status === 200) {
                // If successful, remove the row from the DataTable
                var row = imgTable.row($(this).parents('tr'));
                row.remove().draw(); // Remove the row from the table

                // Optionally, remove the item from the items array
                items = items.filter(item => item[3] !== itemId); // Remove from array
                await loadUploadedImages();
            } else {
                alert('Failed to delete image.');
            }
        } catch (error) {
            console.error('Error deleting image:', error);
            alert('Error deleting image.');
        }
    });

    $('#btnSave').on('click', function () {
        var aboutHeader = $('#title').val();
        var aboutContent = $('#abtBody').val();

        if(aboutHeader === '' || aboutContent === '') {
            swal({
                title: "Error",
                text: "Please fill in both the title and content fields.",
                icon: "error",
                button: "OK"
            })

            return;
        }
    
        // Create a new FormData object
        let formData = {
            aboutHeader: aboutHeader,
            aboutContent: aboutContent
        };
    
        axios.post('/about-us/content/', formData, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            swal({
                title: 'Success!',
                text: 'About Us content saved successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            console.log(response);
        })
        .catch(error => {
            swal({
                title: 'Error!',
                text: 'Error saving About Us content.',
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
            console.error(error);
        });
    });
    



});
