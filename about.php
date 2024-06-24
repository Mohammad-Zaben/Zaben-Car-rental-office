<?php
include "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
    html_header_loged();
else
    html_header();

if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
    vewManaferNav();
} else {
    vewCustomerNav();
}

?>
<main>
<section class="about-section">
        <h1 class="about-title">About Us</h1>
        <p class="about-description">Welcome to our company. We are dedicated to providing the best service possible.</p>
        <div class="about-details">
            <div class="about-mission">
                <h2 class="mission-title">Our Mission</h2>
                <p class="mission-description">Our mission is to provide high quality service that adds value to our customers.</p>
            </div>
            <div class="about-team">
                <h2 class="team-title">Our Team</h2>
                <p class="team-description">We have a diverse and talented team committed to achieving our goals.</p>
            </div>
        </div>
    </section>
</main>
</div>
<?php

html_footer();
