<?php
include "db.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = generateUniqueID();
    $model = $_POST["model"];
    $make = $_POST["make"];
    $type = $_POST["type"];
    $registration_year = $_POST["registration_year"];
    $description = $_POST["description"];
    $price_per_day = $_POST["price_per_day"];
    $capacity_people = $_POST["capacity_people"];
    $capacity_suitcases = $_POST["capacity_suitcases"];
    $colors = $_POST["colors"];
    $fuel_type = $_POST["fuel_type"];
    $average_petroleum_consumption = $_POST["average_petroleum_consumption"];
    $horsepower = $_POST["horsepower"];
    $length = $_POST["length"];
    $width = $_POST["width"];
    $plate_number = $_POST["plate_number"];
    $conditions = $_POST["conditions"];
    $pickup_location = $_POST["pickup_location"];
    $gear_type = $_POST["gear_type"];


    $_FILES['photo1']['name'] = "car" . $car_id . "img1." . returntype($_FILES['photo1']['type']);
    $_FILES['photo2']['name'] = "car" . $car_id . "img2." . returntype($_FILES['photo2']['type']);
    $_FILES['photo3']['name'] = "car" . $car_id . "img3." . returntype($_FILES['photo3']['type']);

    $photo1 = $_FILES["photo1"]["name"];
    $photo2 = $_FILES["photo2"]["name"];
    $photo3 = $_FILES["photo3"]["name"];

    $archive_dir = "images";
    move_uploaded_file($_FILES['photo1']['tmp_name'], "$archive_dir/" . $_FILES['photo1']['name']);
    move_uploaded_file($_FILES['photo2']['tmp_name'], "$archive_dir/" . $_FILES['photo2']['name']);
    move_uploaded_file($_FILES['photo3']['tmp_name'], "$archive_dir/" . $_FILES['photo3']['name']);

    $pdo = connect_database();
    $query = "INSERT INTO Cars (CarID, Model, Make, Type, RegistrationYear, Description, PricePerDay, CapacityPeople, CapacitySuitcases, Colors, FuelType, AveragePetroleumConsumption, Horsepower, Length, Width, PlateNumber, Conditions, Photo1, Photo2, Photo3, PickUpLocation, GearType) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    // Prepare the statement
    $statement = $pdo->prepare($query);

    // Bind values
    $statement->bindValue(1, $car_id);
    $statement->bindValue(2, $model);
    $statement->bindValue(3, $make);
    $statement->bindValue(4, $type);
    $statement->bindValue(5, $registration_year);
    $statement->bindValue(6, $description);
    $statement->bindValue(7, $price_per_day);
    $statement->bindValue(8, $capacity_people);
    $statement->bindValue(9, $capacity_suitcases);
    $statement->bindValue(10, $colors);
    $statement->bindValue(11, $fuel_type);
    $statement->bindValue(12, $average_petroleum_consumption);
    $statement->bindValue(13, $horsepower);
    $statement->bindValue(14, $length);
    $statement->bindValue(15, $width);
    $statement->bindValue(16, $plate_number);
    $statement->bindValue(17, $conditions);
    $statement->bindValue(18, $photo1);
    $statement->bindValue(19, $photo2);
    $statement->bindValue(20, $photo3);
    $statement->bindValue(21, $pickup_location);
    $statement->bindValue(22, $gear_type);

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
        html_header_loged();
    else
        html_header();
    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }

   if ($statement->execute()) {
        echo '<main>';
        echo "<p class='p'>Car added successfully</p>";
        echo "<p class='p'>Car ID: " . $car_id . "</p>";
        echo '</main>';
        echo '</div>';
    } else {
        echo "Error adding car.";
    }
    html_footer();
} else {
    $pdo = connect_database();
    $location_query = "SELECT Name FROM Locations";
    $stmt = $pdo->query($location_query);
    $locations = $stmt->fetchAll();

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
        <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="post" enctype="multipart/form-data" class="formRent">
            <fieldset class="fildste">
                <legend class="legend">Add Car Form:</legend>
                <label class="lable" for="model">Car Model:</label><br>
                <input class="field" type="text" id="model" name="model" required><br><br>

                <label class="lable" for="make">Car Make:</label><br>
                <select class="field" id="make" name="make" required>
                    <?php
                    $makes = ["BMW", "VW", "Volvo", "Audi", "Mercedes", "Toyota", "Honda","Golf","Honday"];
                    foreach ($makes as $make) {
                        echo "<option value=\"$make\">$make</option>";
                    }
                    ?>
                </select><br><br>

                <label class="lable" for="type">Car Type:</label><br>

                <select class="field" id="type" name="type" required>
                    <?php
                    $types = ["Van", "Min-Van", "State", "Sedan", "SUV"];
                    foreach ($types as $type) {
                        echo "<option value=\"$type\">$type</option>";
                    }
                    ?>
                </select><br><br>

                <label class="lable" for="registration_year">Registration Year:</label><br>
                <input class="field" type="number" id="registration_year" name="registration_year" required><br><br>

                <label class="lable" for="description">Brief Description:</label><br>
                <textarea class="field" id="description" name="description" required></textarea><br><br>

                <label class="lable" for="price_per_day">Price Per Day:</label><br>
                <input class="field" type="number" id="price_per_day" name="price_per_day" required><br><br>

                <label class="lable" for="capacity_people">Capacity (People):</label><br>
                <input class="field" type="number" id="capacity_people" name="capacity_people" required><br><br>

                <label class="lable" for="capacity_suitcases">Capacity (Suitcases):</label><br>
                <input class="field" type="number" id="capacity_suitcases" name="capacity_suitcases" required><br><br>

                <label class="lable" for="colors">Colors:</label><br>
                <input class="field" type="text" id="colors" name="colors" required><br><br>

                <label class="lable" for="fuel_type">Fuel Type:</label><br>
                <select class="field" id="fuel_type" name="fuel_type" required>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                </select><br><br>

                <label class="lable" for="average_petroleum_consumption">Average Petroleum Consumption (per 100 km):</label><br>
                <input class="field" type="number" step="0.01" id="average_petroleum_consumption" name="average_petroleum_consumption" required><br><br>

                <label class="lable" for="horsepower">Horsepower:</label><br>
                <input class="field" type="number" id="horsepower" name="horsepower" required><br><br>

                <label class="lable" for="length">Length:</label><br>
                <input class="field" type="number" step="0.01" id="length" name="length" required><br><br>

                <label class="lable" for="width">Width:</label><br>
                <input class="field" type="number" step="0.01" id="width" name="width" required><br><br>

                <label class="lable" for="plate_number">Plate Number:</label><br>
                <input class="field" type="text" id="plate_number" name="plate_number" required><br><br>

                <label class="lable" for="conditions">Conditions or Restrictions:</label><br>
                <textarea class="field" id="conditions" name="conditions"></textarea><br><br>

                <label class="lable" for="photo1">Photo 1:</label><br>
                <input class="field" type="file" id="photo1" name="photo1" accept="image/jpeg, image/png, image/jpg" required><br><br>

                <label class="lable" for="photo2">Photo 2:</label><br>
                <input class="field" type="file" id="photo2" name="photo2" accept="image/jpeg, image/png, image/jpg" required><br><br>

                <label class="lable" for="photo3">Photo 3:</label><br>
                <input class="field" type="file" id="photo3" name="photo3" accept="image/jpeg, image/png, image/jpg" required><br><br>

                <label class="lable" for="pickup_location">Pickup Location:</label><br>
                <select class="field" id="pickup_location" name="pickup_location">
                    <?php foreach ($locations as $location) { ?>
                        <option value="<?php echo $location['Name']; ?>">
                            <?php echo $location['Name']; ?>
                        </option>
                    <?php } ?>
                </select> <br /><br />

                <label class="lable" for="gear_type">Gear Type:</label><br>
                <select class="field" id="gear_type" name="gear_type">
                    <option value="Manual"> Manual</option>
                    <option value="Automatic"> Automatic</option>
                </select> <br /><br />

                <input type="submit" value="Submit" id="submitrent">
            </fieldset>
        </form>
    </main>
    </div>
<?php
    html_footer();
}

function generateUniqueID()
{
    // Generate a unique ID with additional entropy
    $uniqueID = uniqid(mt_rand(), true);
    // Remove non-numeric characters and ensure it is 10 digits long
    $uniqueID = substr(preg_replace("/[^0-9]/", "", $uniqueID), 0, 10);
    return $uniqueID;
}

function returntype($file_type)
{
    $type_parts = explode("/", $file_type);
    $file_extension = $type_parts[1];
    return $file_extension;
}
?>