<?php
include "db.php";
include "Car.php";
session_start();
$pdo = connect_database();
$user_id = $_SESSION["userid"];
$car_id = $_GET["car_id"];
$return_loc = $_GET["ret"];


$query = "UPDATE Caruserstatus SET Status = 'returning' WHERE (UserID = $user_id AND CarID= $car_id)";
$result = $pdo->query($query);

$query = "UPDATE Cars SET PickUpLocation = '$return_loc' WHERE CarID= $car_id";
$result = $pdo->query($query);

if ($result) {
    header("Location: return1.php");
} else {
    error_message("somethink is wrong, try again");
}
