<?php
include "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();
if (isset($_SESSION['logged_in'])) {

    if (isset($_SESSION["do_new_reant"])) {
        unset($_SESSION["do_new_reant"]);
    }

    function stor_session($car)
    {
        if (isset($_POST['car_id'])) {
            $_SESSION["car_id"] = $_POST['car_id'];
        }
        if (isset($_POST["model"])) {
            $_SESSION["model"] = $_POST["model"];
        }
        if (isset($_POST["description"])) {
            $_SESSION["description"] = $_POST["description"];
        }
        if (isset($_POST["from_date"])) {
            $_SESSION["from_date"] = $_POST["from_date"];
        }
        if (isset($_POST["to_date"])) {
            $_SESSION["to_date"] = $_POST["to_date"];
        }
        if (isset($_POST["pickup_location"])) {
            $_SESSION["pickup_location"] = $_POST["pickup_location"];
        }
        if (isset($_POST["total_rent_amount"])) {
            $_SESSION["total_rent_amount"] = $_POST["total_rent_amount"];
        }

        if (isset($_POST["new_location"]) && $_POST["new_location"] != $car->getPickUpLocation()) {
            $_SESSION["Return_location"] = $_POST["new_location"];
            $_SESSION["total_rent_amount"] += 50;
        } else {
            $_SESSION["Return_location"] = $car->getPickUpLocation();
        }

        if (isset($_POST["baby_seats"])) {
            $_SESSION["baby_seats"] = true;
            $_SESSION["total_rent_amount"] += 15;
        }else{
            $_SESSION["baby_seats"] = false;
        }
        if (isset($_POST["insurance"])) {
            $_SESSION["insurance"] = true;
            $_SESSION["total_rent_amount"] += 70;
        }else{
            $_SESSION["insurance"] = false;
        }

        header("Location: rent2.php");
        exit();
    }

    function display_form()
    {
        $car_id = $_GET["car_id"];
        $query = "SELECT * from Cars where CarID = $car_id";
        $pdo = connect_database();
        $result = $pdo->query($query);
        $car = $result->fetchObject("Car");

        $location_query = "SELECT Name FROM Locations";
        $stmt = $pdo->query($location_query);
        $locations = $stmt->fetchAll();
?>
       <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="formRent">
        <fieldset class="fildste">
            <legend class="legend">Rent Car Form:</legend>
            <label class="lable">Car ID: </label><input class="field" type="text" name="car_id" value="<?php echo $car->getCarID() ?>" readonly id="xx"> <br /><br />
            <label class="lable">Car model: </label><input class="field" type="text" name="model" value="<?php echo $car->getModel() ?>" readonly id="xx"> <br /><br />
            <label class="lable">Car Description: </label><textarea class="field" name="description" rows="9" cols="70" readonly id="xx"><?php echo $car->getDescription(); ?></textarea> <br /><br />
            <label class="lable">Pick-up date: </label><input class="field" type="date" id="from_date" name="from_date" value="<?php echo $_SESSION["from_date"] ?? ''; ?>" readonly id="xx"> <br /><br />
            <label class="lable">Return date: </label><input class="field" type="date" id="to_date" name="to_date" value="<?php echo $_SESSION["to_date"] ?? ''; ?>" readonly id="xx"> <br /><br />
            <label class="lable">Total rent amount: </label><input class="field" type="text" id="total_rent_amount" name="total_rent_amount" value="<?php echo calculate_total($car); ?>" readonly id="xx"> <br /><br />
            <label class="lable">Pickup location: </label><input class="field" type="text" id="pickup_location" name="pickup_location" value="<?php echo $_SESSION["pickup_location"] ?? ''; ?>" readonly id="xx"> <br /><br />
        </fieldset>

        <fieldset class="fildste">
            <legend class="legend">Special Requirements</legend>
            <label class="lable">Return to a different location: </label>
            <select class="field" id="new_location" name="new_location">
                <?php foreach ($locations as $location) { ?>
                    <option value="<?php echo $location['Name']; ?>">
                        <?php echo $location['Name']; ?>
                    </option>
                <?php } ?>
            </select> <br /><br />
            <label class="lable">Baby Seats</label>
            <input type="checkbox" name="baby_seats" value="baby_seats"> <br><br>
            <label class="lable">Insurance</label>
            <input type="checkbox" name="insurance" value="insurance">
        </fieldset>
        <br><br>
        <input type="submit" value="Submit" id="submitrent">
    </form>

        </div>
<?php
    }

    function calculate_total($car)
    {
        $from_date = $_SESSION["from_date"];
        $to_date = $_SESSION["to_date"];

        // Create DateTime objects
        $start_date = new DateTime($from_date);
        $end_date = new DateTime($to_date);

        // Calculate the difference
        $interval = $start_date->diff($end_date);

        // Get the number of days
        $days = $interval->days;

        $total = $car->getPricePerDay() * $days;
        return $total;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $car_id = $_POST['car_id'];
        $pdo = connect_database();
        $query = "SELECT * FROM Cars WHERE CarID = :car_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['car_id' => $car_id]);
        $car = $stmt->fetchObject("Car");

        stor_session($car);
    } else {
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
        html_footer();
    }
} else {
    $car_id = $_GET["car_id"];
    $_SESSION["do_new_reant"] = true;
    header("Location: login.php?action=view&car_id=$car_id");
}
?>