@extends('layouts.app')

@section('content')
<style>
    .about_thumb img {
        width: 100vh; /* Make image responsive */
        height: 350px; /* Set fixed height */
        object-fit: cover; /* Crop to fit the space */
    }
    .book_now:hover {
        background-color: #e0494e;
    }

    .single_offers {
    width: 100%;
    max-width: 350px; /* Adjust as needed */
    height: 450px; /* Fixed height */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    overflow: hidden;
}

.about_thumb {
    width: 100%;
    height: 350px; /* Fixed height for image */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.priceP {
    font-size: 16px;
    font-weight: bold;
}

.listItems {
    padding: 0;
    margin: 10px 0;
    text-align: left;
    max-height: 100px;
    overflow-y: auto;
}

.book_now {
    display: block;
    text-align: center;
    background-color: #ff5722;
    color: white;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s ease;
}

.book_now:hover {
    background-color: #e64a19;
}


    
</style>
<div class="slider_area">
    <div class="slider_active owl-carousel">
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Fly with us</h3>
                            <p>Unlock your dreams of traveling the world.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Discover what lies beyond in the world. </h3>
                            <p>Embark on an adventure and uncover the hidden wonders that await beyond the horizon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Explore the breathtaking landscapes</h3>
                            <p>Immerse yourself in the vibrant cultures that make our world so extraordinary.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Wander through nature’s wonders</h3>
                            <p>Let the beauty of the world inspire your soul.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="aboutTab" class="about_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5">
                <div class="about_info">
                    <div class="section_title mb-20px">
                        <h5>About Us</h3>
                        <h3 class="abtHeader"></h3>
                    </div>
                    <p class="abtBody"></p>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7">
                <div class="about_thumb d-flex">
                    <div class="img_1">
                        <img id="about_img_1" src="" alt="">
                    </div>
                    <div class="img_2">
                        <img id="about_img_2" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="promosTab" class="offers_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <h3>Our Promos</h3>
                </div>
            </div>
        </div>
        <div class="row" id="promosContainer">
            <div class="col-xl-4 col-md-4">
                <div class="single_offers">
                    <div class="about_thumb">
                        <img src="img/offers/1.png" alt="">
                    </div>
                    <h3>Up to 35% savings on Club <br>
                        rooms and Suites</h3>
                    <ul>
                        <li>Luxaries condition</li>
                        <li>3 Adults & 2 Children size</li>
                        <li>Sea view side</li>
                    </ul>
                    <a href="#" class="book_now">book now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
