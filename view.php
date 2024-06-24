<?php
require_once "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
function show_Det()
{
    $pdo = connect_database();
    $id = $_GET["car_id"];
    $query = "SELECT * FROM Cars WHERE CarID = $id;";
    $result = $pdo->query($query);
    $car = $result->fetchObject('Car');
    if ($car) {
        echo $car->getCarDetailsPage();
    } else {
        error_message("Product not found.");
    }
    echo "</div>";
}

if (isset($_GET["action"])) {
    if (!empty($_GET["car_id"])) {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
            html_header_loged();
        else
            html_header();
        if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
            vewManaferNav();
        } else {
            vewCustomerNav();
        }
        show_Det();
        html_footer();
    } else {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
            html_header_loged();
        else
            html_header();
        error_message("invalid ID has been sent");
        html_footer();
    }
} else {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
        html_header_loged();
    else
        html_header();
    error_message("Something is wrong!");
    html_footer();
}
