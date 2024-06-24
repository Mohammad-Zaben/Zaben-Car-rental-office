<?php session_start();
include "db.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location_id = generateUniqueID();
    $location_name = $_POST["location_name"];
    $property_number = $_POST["property_number"];
    $street_name = $_POST["street_name"];
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    $country = $_POST["country"];
    $telephone = $_POST["telephone"];

    $pdo = connect_database();
    $query = "INSERT INTO Locations (LocationID,Name,Address,postalCode,Country,PhoneNumber) 
        VALUES (?,?,?,?,?,?)";

    // Prepare the statement
    $statement = $pdo->prepare($query);

    // Bind values
    $statement->bindValue(1, $location_id);
    $statement->bindValue(2, $location_name);
    $statement->bindValue(3, $property_number . $street_name . $city);
    $statement->bindValue(4, $postal_code);
    $statement->bindValue(5, $country);
    $statement->bindValue(6, $telephone);

    html_header_loged();
    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }
    if ($statement->execute()) {
        echo "<main>";
        echo "<strong>Location added successfully</strong>";
        echo "</main>";
        echo "</div>";
    } else {
        echo "Error adding location.";
    }
    html_footer();
} else {

    html_header_loged();
    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }
?>
    <main>

        <h1>Add New Location</h1>

        <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="post" enctype="multipart/form-data" class="formRent">
            <fieldset class="fildste">
                <legend class="legend">Add New Location Form:</legend>
                <label class="lable" for="location name">Location Name:</label><br>
                <input class="field" type="text" id="location_name" name="location_name" required><br><br>

                <label class="lable" for="property_number">Property Number:</label><br>
                <input class="field" type="number" id="property_number" name="property_number" required><br><br>

                <label class="lable" for="street_name">Street Name:</label><br>
                <input class="field" type="text" id="street_name" name="street_name" required><br><br>

                <label class="lable" for="city">City:</label><br>
                <input class="field" type="text" id="city" name="city" required><br><br>

                <label class="lable" for="postal_code">Postal Code:</label><br>
                <input class="field" type="number" id="postal_code" name="postal_code" required><br><br>

                <label class="lable" for="country">Country:</label><br>
                <input class="field" type="text" id="country" name="country" required><br><br>

                <label class="lable" for="telephone">Telephone Number:</label><br>
                <input class="field" type="text" id="telephone" name="telephone" required><br><br>

                <input type="submit" value="Add New Location" id="rent">
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

?>