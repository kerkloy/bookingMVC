var descriptionLists = [];
var deletedDescriptions = [];

    // Preview image on selection
    $('#img').on('change', function(event) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        };

        reader.readAsDataURL(event.target.files[0]);
    });

    // Function to add descriptions to the list
    function addItem() {
        const description = $("#descriptionInput").val();
        if (description !== "") {
            descriptionLists.push({description});

            // console.log(descriptionLists);
            const listItem = $('<li class="list-group-item"></li>').text(description);
            const deleteButton = $('<span class="delete-btn">X</span>');
            deleteButton.on('click', function() {
                $(this).parent().remove();
                const index = descriptionLists.indexOf(description);
                if (index > -1) {
                    descriptionLists.splice(index, 1);
                }
            });
            listItem.append(deleteButton);
            $("#itemList").append(listItem);
            $("#descriptionInput").val("");
        }
    }

    function submitPromo() {
        const promoHeader = $('#promoHeader').val();
        const imageFile = $('#img')[0].files[0];
        const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
        if (!promoHeader || !imageFile || descriptionLists.length === 0) {
            swal({
                title: 'Error',
                text: 'Please fill all the required fields',
                icon: 'error',
                button: 'OK'
            });
            return;
        }
    
        // Check if the file size exceeds 2MB
        if (imageFile.size > maxFileSize) {
            swal({
                title: 'Error',
                text: 'File size must be lower than 2MB',
                icon: 'error',
                button: 'OK'
            });
            return;
        }
        const formData = new FormData();
        formData.append('promoHeader', promoHeader);
        formData.append('img', imageFile);

        descriptionLists.forEach((description, index) => {
            formData.append(`lines[${index}][description]`, description.description);
        });
        axios.post('/promos', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            swal({
                title: 'Success',
                text: 'Promo submitted successfully!',
                icon: 'success',
                button: 'OK'
            }).then((willReload) => {
                if (willReload) {
                    window.location.reload();
                }
            });
        })
        .catch(error => {
            console.error('Error submitting promo:', error.response.data);
        });
    }

//     function submitPromo() {
//         const promoHeader = $('#promoHeader').val();
//         const imageFile = $('#img')[0].files[0];
//         const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
//         const promoId = "{{ isset($promo[0]->promo_id) ? $promo[0]->promo_id : '' }}"; // Get promo ID if editing
    
//         if (!promoHeader || descriptionLists.length === 0) {
//             swal({
//                 title: 'Error',
//                 text: 'Please fill all the required fields',
//                 icon: 'error',
//                 button: 'OK'
//             });
//             return;
//         }
    
//         if (imageFile && imageFile.size > maxFileSize) {
//             swal({
//                 title: 'Error',
//                 text: 'File size must be lower than 2MB',
//                 icon: 'error',
//                 button: 'OK'
//             });
//             return;
//         }
    
//         const formData = new FormData();
//         formData.append('promoHeader', promoHeader);
//         if (imageFile) {
//             formData.append('img', imageFile); // Append the image if a new one is uploaded
//         }
    
//         descriptionLists.forEach((description, index) => {
//             formData.append(`lines[${index}][description]`, description.description);
//         });
    
//         // If editing, delete descriptions marked for deletion
//         deletedDescriptions.forEach((descriptionId, index) => {
//             formData.append(`deleted[${index}]`, descriptionId);
//         });
    
//         let url = promoId ? `/promos/${promoId}` : '/promos';
//         let method = promoId ? 'PUT' : 'POST';
    
//         axios({
//             method: method,
//             url: url,
//             data: formData,
//             headers: {
//                 'Content-Type': 'multipart/form-data'
//             }
//         })
//         .then(response => {
//             swal({
//                 title: 'Success',
//                 text: 'Promo submitted successfully!',
//                 icon: 'success',
//                 button: 'OK'
//             }).then((willReload) => {
//                 if (willReload) {
//                     window.location.reload();
//                 }
//             });
//         })
//         .catch(error => {
//             console.error('Error submitting promo:', error.response.data);
//         });
//     }


//     function deleteDescription(descriptionId) {
//     deletedDescriptions.push(descriptionId); 
//     $(`#description-${descriptionId}`).remove();
// }
    
    
