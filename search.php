<?php
include "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";

session_start();


if (isset($_GET['order_by'])) {
    $order_by = $_GET['order_by'];
    setcookie("order_by", "$order_by", time() + 86400);
    if (isset($_COOKIE['sort_order'])) {
        $sort_order = $_COOKIE['sort_order'];
    }

    setcookie("sort_order", "ASC", time() + 86400);
} else if (isset($_COOKIE['order_by']) && isset($_COOKIE['sort_order'])) {
    $order_by = $_COOKIE['order_by'];
    $sort_order = $_COOKIE['sort_order'];
} else {
    setcookie("order_by", "PricePerDay", time() + 86400);
    setcookie("sort_order", "ASC", time() + 86400);
    $order_by = "PricePerDay"; // defult value
    $sort_order = "ASC";
}


if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}


$from_date = !empty($_SESSION['from_date']) ? $_SESSION['from_date'] : date('Y-m-d');
$to_date = !empty($_SESSION['to_date']) ? $_SESSION['to_date'] : date('Y-m-d', strtotime('+3 days'));
$car_type = !empty($_SESSION['car_type']) ? $_SESSION['car_type'] : 'Sedan';
$pickup_location = !empty($_SESSION['pickup_location']) ? $_SESSION['pickup_location'] : 'Birzeit';
$min_price = !empty($_SESSION['min_price']) ? $_SESSION['min_price'] : 200;
$max_price = !empty($_SESSION['max_price']) ? $_SESSION['max_price'] : 100;

list_filtter_records();

function list_filtter_records()
{
    global $order_by;
    global $sort_order;
    global $from_date;
    global $to_date;
    global $car_type;;
    global $pickup_location;
    global $min_price;
    global $max_price;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $from_date = !empty($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d');
        $to_date = !empty($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d', strtotime('+3 days'));
        $car_type = !empty($_POST['car_type']) ? $_POST['car_type'] : 'Sedan';
        $pickup_location = !empty($_POST['pickup_location']) ? $_POST['pickup_location'] : 'Birzeit';
        $min_price = !empty($_POST['min_price']) ? $_POST['min_price'] : 200;
        $max_price = !empty($_POST['max_price']) ? $_POST['max_price'] : 1000;
    }

    $_SESSION["from_date"] = $from_date;
    $_SESSION["to_date"] = $to_date;
    $_SESSION["car_type"] = $car_type;
    $_SESSION["pickup_location"] = $pickup_location;
    $_SESSION["min_price"] = $min_price;
    $_SESSION["max_price"] = $max_price;


    $pdo = connect_database();
    if (!$pdo) error_message("Null PDO Object");


    $query = "SELECT c.* FROM Cars c LEFT JOIN Reservations r ON c.CarID = r.CarID WHERE c.Type = '$car_type' 
    AND c.PricePerDay BETWEEN $min_price AND $max_price AND c.PickUpLocation = '$pickup_location'AND c.Status='available' AND (r.CarID IS NULL 
    OR (r.StartDate > '$to_date' OR r.EndDate < '$from_date')) ORDER BY $order_by $sort_order;";
    $result = $pdo->query($query);

    if ($_COOKIE['sort_order'] === "ASC") {
        setcookie("sort_order", "DESC", time() + 86400);
    } else {
        setcookie("sort_order", "ASC", time() + 86400);
    }


    if ($sort_order == 'ASC') {
        $sort_order = 'DESC';
        $org_sort_order = 'ASC';
    } else {
        $sort_order = 'ASC';
        $org_sort_order = 'DESC';
    }
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
        html_header_loged();
    else
        html_header();
    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }

    display_form();
    displat_table($result);
    html_footer();
}



function display_form()
{
     $pdo = connect_database();
     $location_query = "SELECT Name FROM Locations";
    $stmt = $pdo->query($location_query);
    $locations = $stmt->fetchAll();
?>

    <main>
        <form action="search.php" method="post" >
            <label for="from_date">From Date:</label>
            <input type="date" id="from_date" name="from_date" value="<?php echo $_SESSION["from_date"]; ?>">
            <label for="to_date">To Date:</label>
            <input type="date" id="to_date" name="to_date" value="<?php echo $_SESSION["to_date"]; ?>">
            <label for="car_type">Car Type:</label>
           <select id="car_type" name="car_type">
                <?php

                $types = ["Van", "Min-Van", "State", "Sedan", "SUV"];
                foreach ($types as $type) {
                    if ($type == $_SESSION["car_type"])
                        echo "<option value=\"$type\" selected>$type</option>";
                    else
                        echo "<option value=\"$type\">$type</option>";
                }
                ?>
            </select>
            <label for="pickup_location">Pick-up Location:</label>
            
            <select id="pickup_location" name="pickup_location">
                    <?php foreach ($locations as $location) { ?>
                        <option value="<?php echo $location['Name']; ?>">
                            <?php echo $location['Name']; ?>
                        </option>
                    <?php } ?>
                </select>
                
            <label for="min_price">Min Price:</label>
            <input type="number" id="min_price" name="min_price" value="200">
            <label for="max_price">Max Price:</label>
            <input type="number" id="max_price" name="max_price" value="1000">
            <input type="submit" value="Search">
        </form>
    <?php
}


function displat_table($result)
{
    global $sort_order;
    ?>
        <br><br>
        <table class="content-table">

            <thead>
                <tr>
                    <th> <a href="search.php?ored" id="tabel">cheack box</a></th>
                    <th><a href="search.php?order_by=PricePerDay" id="tabel">Price per Day</a></th>
                    <th><a href="search.php?order_by=Type" id="tabel">Car type</a></th>
                    <th><a href="search.php?order_by=FuelType" id="tabel">Fuel type</a></th>
                    <th><a href="search.php?order_by=FuelType" id="tabel">Car Photo</a></th>
                    <th><a href="search.php?order_by=CarID" id="tabel">Rent</a></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($car = $result->fetchObject('Car'))
                echo $car->getTableRow();
            echo "</tbody>";
            echo "</table>";

            echo "</main> </div>";
        }
