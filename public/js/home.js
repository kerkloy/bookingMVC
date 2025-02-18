$(document).ready(function() {
    axios.get('http://127.0.0.1:8000/about-us/get-content')
    .then(function(response) {
        console.log(response.data);
        const abtHeader = response.data[0].aboutHeader;
        const abtBody = response.data[0].aboutParagraph;

        $('.abtHeader').text(abtHeader);
        $('.abtBody').text(abtBody);
    })
    .catch(function(error) {
        console.log(error);
    });


    axios.get('http://127.0.0.1:8000/about-us/images')
    .then(function(response) {
        console.log(response.data);
        
        if (response.data.length >= 2) {
            // Update the image sources dynamically
            $("#about_img_1").attr("src", "/" + response.data[0].image_path);
            $("#about_img_2").attr("src", "/" + response.data[1].image_path);
        }
    })
    .catch(function(error) {
        console.error("Error fetching images:", error);
    });


    axios.get('http://127.0.0.1:8000/all-promos')
    .then(function(response) {
        const promosContainer = document.getElementById("promosContainer"); // Make sure you have this div in your HTML
        const allPromos = response.data;
        const groupedPromos = {};

        // Group promos by promo_id
        allPromos.forEach(promo => {
            if (!groupedPromos[promo.promo_id]) {
                groupedPromos[promo.promo_id] = [];
            }
            groupedPromos[promo.promo_id].push(promo);
        });

        // Clear previous content
        promosContainer.innerHTML = "";

        // Iterate over grouped promos and append to the container
        Object.keys(groupedPromos).forEach(promoId => {
            const promos = groupedPromos[promoId];

            // Extract promo details (taking the first entry for shared details)
            const promoHeader = promos[0].promo_header;
            const promoPrice = promos[0].promo_price;
            const imageUrl = promos[0].image_url;

            // Create a new promo card
            const promoCard = document.createElement("div");
            promoCard.classList.add("col-xl-4", "col-md-4");

            promoCard.innerHTML = `
                <div class="single_offers">
                    <div class="about_thumb">
                        <img src="${imageUrl}" alt="Promo Image">
                    </div>
                    <h3>${promoHeader}</h3>
                    <p><strong>Price: ${promoPrice}</strong></p>
                    <ul>
                        ${promos.map(promo => `<li>${promo.description}</li>`).join("")}
                    </ul>
                    <a href="#" class="book_now">book now</a>
                </div>
            `;

            // Append to container
            promosContainer.appendChild(promoCard);
        });
    })
    .catch(function(error) {
        console.log(error);
    });



});