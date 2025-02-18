var descriptionLists = [];
var index = 0;
// var description;


$(document).ready(function() {
    var arr = $('#dtBody').data('data');
    console.log(arr);

    if(arr != '') {
        arr.forEach(value => {
            descriptionLists.push({
                index : index,
                description : value.description,
                Action :  ` <button class='btn btn-sm btn-danger' onclick='deleteDescription(${index})'>Delete</button>`
            });
            index++;
        })
    }
    descTable();


    $('.btnSubmit').on('click', function(){
        submitPromo();
    });

    $('.btnEdit').on('click', function(){
        editPromo();
    });
});
    // Preview image on selection
    $('#img').on('change', function(event) {
        const reader = new FileReader();

        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        };

        reader.readAsDataURL(event.target.files[0]);
    });

    $('#addDesc').on('click', function() {
        let description = $("#descriptionInput").val();
        if (description !== "") {
            descriptionLists.push({
                index: index++,
                description: description,
                Action : ` <button class='btn btn-sm btn-danger' onclick='deleteDescription(${index})'>Delete</button>`});
        }
        $("#descriptionInput").val('');
        descTable();

        console.log(descriptionLists);
    });

    function descTable() {
        $('#dataTable').DataTable().destroy();
        $('#dataTable').DataTable({
            info: false,
            data: descriptionLists,
            paging: false,
            searching: false,
            columns: [
                { data: 'description', title: "Description" },
                { data: 'Action', title: "Action" }
            ]
        });

        console.log(descriptionLists);
    }


    function submitPromo() {
        const promoHeader = $('#promoHeader').val();
        const promoType = $('#promoType').val();
        const promoPrice = $('#promoPrice').val();
        const promoLocation = $('#promoLocation').val();

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
        formData.append('promoType', promoType);
        formData.append('promoPrice', promoPrice);
        formData.append('promoLocation', promoLocation);
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

    function editPromo() {
        const promoHeader = $('#promoHeader').val();
        const promoType = $('#promoType').val();
        const promoPrice = $('#promoPrice').val();
        const promoLocation = $('#promoLocation').val();
        const pID = $('#pID').val();

        const imageFile = $('#img')[0].files[0];
        const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
        if (!promoHeader || descriptionLists.length === 0) {
            swal({
                title: 'Error',
                text: 'Please fill all the required fields',
                icon: 'error',
                button: 'OK'
            });
            return;
        }
    
        // Check if the file size exceeds 2MB
        if (imageFile == true && imageFile.size > maxFileSize) {
            swal({
                title: 'Error',
                text: 'File size must be lower than 2MB',
                icon: 'error',
                button: 'OK'
            });
            return;
        } else {
            const formData = {
                promoHeader : promoHeader ,
                promoType: promoType,
                promoPrice: promoPrice,
                promoLocation: promoLocation ,
                img: imageFile,
                lines: descriptionLists.map((description) => ({
                    description: description.description
                }))
            }

            // descriptionLists.forEach((description, index) => {
            //     formData.append(`lines[${index}][description]`, description.description);
            // });
            
            // return console.log(formData);
            axios.put(`/promos/${pID}`, formData)
            .then(response => {
                console.log(response);
                swal({
                    title: 'Success',
                    text: 'Promo edited successfully!',
                    icon: 'success',
                    button: 'OK'
                }).then((willReload) => {
                    if (willReload) {
                        window.location.reload();
                    }
                });
            })
            .catch(error => {
                console.log(error);
                console.error('Error submitting promo:', error.response.data);
            });
        }
        
    }

    function deleteDescription(index) {
        descriptionLists.splice(index, 1);
        descTable();
    }