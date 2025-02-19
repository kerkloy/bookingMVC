$(document).ready(function() {
    axios.get('http://127.0.0.1:8000/about-us/get-content')
    .then(function(response) {
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

        console.log(allPromos);
        const groupedPromos = {};

        // Group promos by promo_id
        allPromos.forEach(promo => {
            if (!groupedPromos[promo.promo_id]) {
                groupedPromos[promo.promo_id] = promo;
            }
        });

        // Clear previous content
        promosContainer.innerHTML = "";

        // Iterate over grouped promos and append to the container
        Object.values(groupedPromos).forEach(promo => {
            const { promo_header, promo_price, image_url, promo_id, promo_location, inclusions, exclusions } = promo;

            // Format inclusions and exclusions
            const formattedInclusions = inclusions.map(item => `<li style="list-style: none !important;">✅ ${item}</li>`).join("");
            const formattedExclusions = exclusions.map(item => `<li style="list-style: none !important;">❌ ${item}</li>`).join("");

            // Create a new promo card
            const promoCard = document.createElement("div");
            promoCard.classList.add("col-xl-4", "col-md-4");

            promoCard.innerHTML = `
                <div class="single_offers mt-3 mb-4">
                    <div class="about_thumb mb-2">
                        <img src="${image_url}" alt="Promo Image" style="width: 100%; height: auto; border-radius: 10px;">
                    </div>
                    <h5>${promo_header}</h5>
                    
                    <p class="priceP"><strong>💰 Price Per Pax: ${promo_price}</strong></p>
                    <ul class="listItems">
                        <li><strong>✅ Inclusions:</strong></li>
                        ${formattedInclusions}
                        <li><strong>❌ Exclusions:</strong></li>
                        ${formattedExclusions}
                    </ul>
                    <a href="http://127.0.0.1:8000/promos/${promo_id}" class="book_now">Show More Details</a>
                </div>
            `;

            // Append to container
            promosContainer.appendChild(promoCard);
        });
        
    })
    .catch(function(error) {
        console.log(error);
    });


    var $links = $("#navigation .nav-link");

    // Function to update active link based on URL hash
    function updateActiveLinkFromHash() {
        var currentHash = window.location.hash; 
        if (!currentHash) {
            // If no hash exists, mark Home as active (assumes Home link doesn't use a hash)
            $links.removeClass("active");
            $links.filter(function() {
                return $(this).attr("href").charAt(0) !== "#";
            }).addClass("active");
        } else {
            $links.each(function() {
                var $link = $(this);
                if ($link.attr("href") === currentHash) {
                    $link.addClass("active");
                } else {
                    $link.removeClass("active");
                }
            });
        }
    }

    // Function to update active link based on scroll position
    function updateActiveLinkOnScroll() {
        var scrollPos = $(document).scrollTop();

        // Array of links that point to in-page sections (with hashes)
        var $scrollLinks = $links.filter(function() {
            return $(this).attr("href").charAt(0) === "#";
        });
        
        // If we're near the top of the page, show Home as active
        if ($scrollLinks.length && scrollPos < $($scrollLinks.first().attr("href")).offset().top) {
            $links.removeClass("active");
            $links.filter(function() {
                return $(this).attr("href").charAt(0) !== "#";
            }).addClass("active");
            return;
        }

        // Loop through each scrollable section to determine if it is in view
        $scrollLinks.each(function() {
            var $link = $(this);
            var targetID = $link.attr("href");
            var $target = $(targetID);
            if ($target.length) {
                // Calculate section boundaries
                var offsetTop = $target.offset().top;
                var offsetBottom = offsetTop + $target.outerHeight();

                // You can adjust the offset (e.g., for fixed headers) by subtracting pixels from offsetTop
                if (scrollPos >= offsetTop - 10 && scrollPos < offsetBottom - 10) {
                    $links.removeClass("active");
                    $link.addClass("active");
                }
            }
        });
    }

    // Update active link on page load based on the hash
    updateActiveLinkFromHash();

    // Update active link when the URL hash changes
    $(window).on("hashchange", updateActiveLinkFromHash);

    // Immediate active class update on link click
    $links.on("click", function() {
        // Remove active from all links and add it to the clicked link
        $links.removeClass("active");
        $(this).addClass("active");
    });

    // Listen for scroll events to update active navigation based on current section
    $(window).on("scroll", function() {
        updateActiveLinkOnScroll();
    });


});