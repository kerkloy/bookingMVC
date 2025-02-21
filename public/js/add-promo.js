var descriptionLists = [];
var exclusionLists = [];
var itineraryLists = [];
var indexIn = 0;
var indexEx = 0;
var indexIt = 0;
// var description;


$(document).ready(function() {
    const arr1 = $('#dtBody').data('data') || {};
    const arr2 = $('#exBody').data('data') || {};
    const arr3 = $('#itBody').data('data') || {};

    if (Array.isArray(arr1.inclusions)) {
        arr1.inclusions.forEach(value => {
            descriptionLists.push({
                indexIn: indexIn,
                description: value,
                Action: `<button class='btn btn-sm btn-danger' onclick='deleteDescription(${indexIn})'>Delete</button>`
            });
            indexIn++;
        });
    }
    descTable();

    if (Array.isArray(arr2.exclusions)) {
        arr2.exclusions.forEach(value => {
            exclusionLists.push({
                indexEx: indexEx,
                exclusion: value,
                Action: `<button class='btn btn-sm btn-danger' onclick='deleteExclusion(${indexEx})'>Delete</button>`
            });
            indexEx++;
        });
    }
    exclusionTable();

    if (Array.isArray(arr3.itineraries)) {
        arr3.itineraries.forEach(value => {
            itineraryLists.push({
                indexIt: indexIt,
                itinerary: value,
                Action: `<button class='btn btn-sm btn-danger' onclick='deleteItinerary(${indexIt})'>Delete</button>`
            });
            indexIt ++;
        });
    }
    itineraryTable();



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
                indexIn: indexIn++,
                description: description,
                Action : ` <button class='btn btn-sm btn-danger' onclick='deleteDescription(${indexIn-1})'>Delete</button>`});
        }
        $("#descriptionInput").val('');
        descTable();

        console.log(descriptionLists);
    });

    $('#addExclusion').on('click', function() {
        let exclusion = $("#exclusionInput").val();
        if (exclusion !== "") {
            exclusionLists.push({
                indexEx: indexEx++,
                exclusion: exclusion,
                Action : ` <button class='btn btn-sm btn-danger' onclick='deleteExclusion(${indexEx-1})'>Delete</button>`});
        }
        $("#exclusionInput").val('');
        exclusionTable();

        console.log(exclusionLists);
    });

    $('#addItinerary').on('click', function() {
        let itinerary = $("#itineraryInput").val();
        if (itinerary !== "") {
            itineraryLists.push({
                indexIt: indexIt++,
                itinerary: itinerary,
                Action : ` <button class='btn btn-sm btn-danger' onclick='deleteItinerary(${indexIt-1})'>Delete</button>`});
        }
        $("#itineraryInput").val('');
        itineraryTable();

        console.log(itineraryLists);
    });

    function descTable() {
        $('#dataTable').DataTable().destroy();
        $('#dataTable').DataTable({
            info: false,
            data: descriptionLists,
            paging: false,
            searching: false,
            columns: [
                { data: 'description', title: "Inclusion" },
                { data: 'Action', title: "Action" }
            ]
        });
    }

    function exclusionTable() {
        $('#exclusionTable').DataTable().destroy();
        $('#exclusionTable').DataTable({
            info: false,
            data: exclusionLists,
            paging: false,
            searching: false,
            columns: [
                { data: 'exclusion', title: "Exclusion" },
                { data: 'Action', title: "Action" }
            ]
        });
    }

    function itineraryTable() {
        $('#itineraryTable').DataTable().destroy();
        $('#itineraryTable').DataTable({
            info: false,
            data: itineraryLists,
            paging: false,
            searching: false,
            columns: [
                { data: 'itinerary', title: "Itinerary" },
                { data: 'Action', title: "Action" }
            ]
        });
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

        descriptionLists.forEach((description, indexIn) => {
            formData.append(`lines[${indexIn}][description]`, description.description);
        });

        exclusionLists.forEach((exclusion, indexEx) => {
            formData.append(`exclusions[${indexEx}][exclusion]`, exclusion.exclusion);
        });

        itineraryLists.forEach((itinerary, indexIt) => {
            formData.append(`itineraries[${indexIt}][itinerary]`, itinerary.itinerary);
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

    // function editPromo() {
    //     const promoHeader = $('#promoHeader').val();
    //     const promoType = $('#promoType').val();
    //     const promoPrice = $('#promoPrice').val();
    //     const promoLocation = $('#promoLocation').val();
    //     const pID = $('#pID').val();

    //     const imageFile = $('#img')[0].files[0];
    //     const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
    //     if (!promoHeader || descriptionLists.length === 0) {
    //         swal({
    //             title: 'Error',
    //             text: 'Please fill all the required fields',
    //             icon: 'error',
    //             button: 'OK'
    //         });
    //         return;
    //     }
    
    //     // Check if the file size exceeds 2MB
    //     if (imageFile == true && imageFile.size > maxFileSize) {
    //         swal({
    //             title: 'Error',
    //             text: 'File size must be lower than 2MB',
    //             icon: 'error',
    //             button: 'OK'
    //         });
    //         return;
    //     } else {
    //         const formData = {
    //             promoHeader : promoHeader ,
    //             promoType: promoType,
    //             promoPrice: promoPrice,
    //             promoLocation: promoLocation ,
    //             img: imageFile,
    //             lines: descriptionLists.map((description) => ({
    //                 description: description.description
    //             }))
    //         }

    //         // descriptionLists.forEach((description, index) => {
    //         //     formData.append(`lines[${index}][description]`, description.description);
    //         // });
            
    //         // return console.log(formData);
    //         axios.put(`/promos/${pID}`, formData)
    //         .then(response => {
    //             console.log(response);
    //             swal({
    //                 title: 'Success',
    //                 text: 'Promo edited successfully!',
    //                 icon: 'success',
    //                 button: 'OK'
    //             }).then((willReload) => {
    //                 if (willReload) {
    //                     window.location.reload();
    //                 }
    //             });
    //         })
    //         .catch(error => {
    //             console.log(error);
    //             console.error('Error submitting promo:', error.response.data);
    //         });
    //     }
        
    // }

    function deleteDescription(indexIn) {
        const itemIndex = descriptionLists.findIndex(item => item.indexIn === indexIn);
        if (itemIndex !== -1) {  // Ensure the item exists
            descriptionLists.splice(itemIndex, 1);
        }
        descTable();
        console.log(descriptionLists);
    }
    

    function deleteExclusion(indexEx) {
        const itemIndex = exclusionLists.findIndex(item => item.indexEx === indexEx);
        if(itemIndex !== -1) { // Ensure the item exists
        exclusionLists.splice(itemIndex, 1);
        }
        exclusionTable();
        console.log(exclusionLists);
    }

    function deleteItinerary(indexIt) {
        const itemIndex = itineraryLists.findIndex(item => item.indexIt === indexIt);
        if(itemIndex!== -1) { // Ensure the item exists
        itineraryLists.splice(itemIndex, 1);
        }
        itineraryTable();
    }