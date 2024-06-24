<?php include "db.php";
include "Car.php";
include "type/manager/managerNav.php";
$pdo = connect_database();
session_start();

html_header_loged();
vewManaferNav();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_id = $_POST["car_id"];
    $puck_loc = $_POST["pickup_location"];
    $status = $_POST["status"];

    $user_id = $_POST["user_id"];

    $query = "UPDATE Cars SET PickUpLocation = '$puck_loc',Status = '$status' WHERE CarID= $car_id";
    $result = $pdo->query($query);

    $query = "UPDATE Caruserstatus SET Status = 'isReturn' WHERE CarID= $car_id AND UserID = $user_id";
    $result = $pdo->query($query);
    if ($result) {
        echo "<p class='p'>done 😎👍</p>";
        echo"</main>";
echo"</div>";
    }
} else {

    $car_id = $_GET["car_id"];
    $user_id = $_GET["user_id"];

    $query = "SELECT * FROM Cars where CarID= $car_id";
    $result = $pdo->query($query);
    $car = $result->fetchObject('Car');

    $location_query = "SELECT Name FROM Locations";
    $result = $pdo->query($location_query);
    $locations = $result->fetchAll();

?>
<main>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="formRent">
       <fieldset class="fildste">
            <legend class="legend">Return car Form:</legend>
        <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->getCarID(); ?>"><br><br>
        <input class="field" type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>"><br><br>

        <label class="lable" for="car_id">Car ID:</label><br>
        <input class="field" type="text" id="car_id" name="car" value="<?php echo $car->getCarID(); ?>" readonly><br><br>

        <label class="lable" for="model">Model:</label><br>
        <input class="field" type="text" id="model" name="model" value="<?php echo $car->getModel(); ?>" readonly><br><br>

        <label class="lable" for="make">Make:</label><br>
        <input class="field" type="text" id="make" name="make" value="<?php echo $car->getMake(); ?>" readonly><br><br>

        <label class="lable" for="type">Type:</label><br>
        <input class="field" type="text" id="type" name="type" value="<?php echo $car->getType(); ?>" readonly><br><br>

        <label class="lable" for="registration_year">Registration Year:</label><br>
        <input class="field" type="text" id="registration_year" name="registration_year" value="<?php echo $car->getRegistrationYear(); ?>" readonly><br><br>

        <label class="lable" for="description">Description:</label><br>
        <input class="field" type="text" id="description" name="description" value="<?php echo $car->getDescription(); ?>" readonly><br><br>

        <label class="lable" for="price_per_day">Price Per Day:</label><br>
        <input class="field" type="text" id="price_per_day" name="price_per_day" value="<?php echo $car->getPricePerDay(); ?>" readonly><br><br>

        <label class="lable" for="capacity_people">Capacity People:</label><br>
        <input class="field" type="text" id="capacity_people" name="capacity_people" value="<?php echo $car->getCapacityPeople(); ?>" readonly><br><br>

        <label class="lable" for="capacity_suitcases">Capacity Suitcases:</label><br>
        <input class="field" type="text" id="capacity_suitcases" name="capacity_suitcases" value="<?php echo $car->getCapacitySuitcases(); ?>" readonly><br><br>

        <label class="lable" for="colors">Colors:</label><br>
        <input class="field" type="text" id="colors" name="colors" value="<?php echo $car->getColors(); ?>" readonly><br><br>

        <label class="lable" for="fuel_type">Fuel Type:</label><br>
        <input class="field" type="text" id="fuel_type" name="fuel_type" value="<?php echo $car->getFuelType(); ?>" readonly><br><br>

        <label class="lable" for="average_petroleum_consumption">Average Petroleum Consumption:</label><br>
        <input class="field" type="text" id="average_petroleum_consumption" name="average_petroleum_consumption" value="<?php echo $car->getAveragePetroleumConsumption(); ?>" readonly><br><br>

        <label class="lable" for="horsepower">Horsepower:</label><br>
        <input class="field" type="text" id="horsepower" name="horsepower" value="<?php echo $car->getHorsepower(); ?>" readonly><br><br>

        <label class="lable" for="length">Length:</label><br>
        <input class="field" type="text" id="length" name="length" value="<?php echo $car->getLength(); ?>" readonly><br><br>

        <label class="lable" for="width">Width:</label><br>
        <input class="field" type="text" id="width" name="width" value="<?php echo $car->getWidth(); ?>" readonly><br><br>

        <label class="lable" for="plate_number">Plate Number:</label><br>
        <input class="field" type="text" id="plate_number" name="plate_number" value="<?php echo $car->getPlateNumber(); ?>" readonly><br><br>

        <label class="lable" for="conditions">Conditions:</label><br>
        <input class="field" type="text" id="conditions" name="conditions" value="<?php echo $car->getConditions(); ?>" readonly><br><br>

        <label class="lable" for="pickup_location">Pick Up Location:</label><br>

        <select class="field" id="pickup_location" name="pickup_location">
            <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location['Name']; ?>">
                    <?php echo $location['Name']; ?>
                </option>
            <?php } ?>
        </select> <br /><br />

        <label class="lable" for="status">Status:</label><br>
        <select class="field" id="status" name="status">
            <option value="available">Available</option>
            <option value="damaged">Damaged</option>
            <option value="repair">Repair</option>
        </select><br><br>

        <input type="submit" value="Submit" id="rent">
        </fieldset>
    </form>
</main>
</div>
<?php
}
html_footer();
