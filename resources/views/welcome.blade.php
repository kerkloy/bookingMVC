@extends('layouts.app')

@section('content')
<style>
    .about_thumb img {
        width: 100vh; /* Make image responsive */
        height: 200px; /* Set fixed height */
        object-fit: cover; /* Crop to fit the space */
        border-radius: 2px;
    }

    /* .book_now {
        display: block;
        text-align: center;
        margin-top: 10px;
        padding: 8px;
        background-color: #ff5a5f;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    } */

    .book_now:hover {
        background-color: #e0494e;
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

<div class="about_area">
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

<div class="offers_area">
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
