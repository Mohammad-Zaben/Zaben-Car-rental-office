<?php
include "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentDate = new DateTime();
    if ($_POST["expiration_date"] < $currentDate->format('Y-m-d')) {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
            html_header_loged();
        else
            html_header();
        if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
            vewManaferNav();
        } else {
            vewCustomerNav();
        }
        error_message("The expiry date of the card is invalid");
        html_footer();
    } else {
        $_SESSION['credit_name'] = $_POST['credit_name'];
        $_SESSION['expiration_date'] = $_POST['expiration_date'];
        $_SESSION['holder_name'] = $_POST['holder_name'];
        $_SESSION['bank_name'] = $_POST['bank_name'];
        $_SESSION['credit_type'] = $_POST['credit_type'];
        $_SESSION['accept'] = $_POST['accept'];
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['date'] = $_POST['date'];
        header('Location: rent3.php');
    }
} else {
    $pdo = connect_database();
    $user_id = $_SESSION["userid"];
    $query = "SELECT * FROM Users where UserID = $user_id";
    $result = $pdo->query($query);
    $user = $result->fetch();

    $car_id =  $_SESSION["car_id"];
    $query = "SELECT * FROM Cars where CarID = $car_id";
    $result = $pdo->query($query);
    $car = $result->fetchObject('Car');

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
        <div class="invoice-header">
            <h1>Invoice Details</h1>
        </div>
        <table class="content-table" id="inv">
            <tr>
                <td>Customer ID:</td>
                <td><?php echo $user["UserID"] ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><?php echo $user["Name"] ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo $user["Address"] ?></td>
            </tr>
            <tr>
                <td>Telephone:</td>
                <td><?php echo $user["Telephone"] ?></td>
            </tr>
            <tr>
                <td>Pick-up Date:</td>
                <td><?php echo $_SESSION["from_date"] ?></td>
            </tr>
            <tr>
                <td>Pick-up Location:</td>
                <td><?php echo $_SESSION["pickup_location"] ?></td>
            </tr>
            <tr>
                <td>Return Date:</td>
                <td><?php echo $_SESSION["to_date"] ?></td>
            </tr>
            <tr>
                <td>Return Location:</td>
                <td><?php echo $_SESSION["Return_location"] ?></td>
            </tr>
            <tr>
                <td>Car Model:</td>
                <td><?php echo $car->getModel() ?></td>
            </tr>
            <tr>
                <td>Car Type:</td>
                <td><?php echo $car->getType(); ?></td>
            </tr>
            <tr>
                <td>Fuel Type:</td>
                <td><?php echo $car->getFuelType(); ?></td>
            </tr>
            <tr>
                <td>Insurance:</td>
                <td><?php echo isset($_SESSION["insurance"]) ? 'true' : 'false'; ?></td>
            </tr>
            <tr>
                <td>Baby Seats:</td>
                <td><?php echo isset($_SESSION["baby_seats"]) ? 'true' : 'false'; ?></td>
            </tr>
            <tr>
                <td class="total-amount">Total Amount:</td>
                <td class="total-amount"><?php echo $_SESSION["total_rent_amount"] . "$" ?></td>
            </tr>
        </table>

        <br><br>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="formRent">
            <fieldset class="fildste">
                <label>Credit Card Number:</label><input class="field" type="number" name="credit_name" min="100000000" max="999999999" required><br><br>
                <label>Credit expiration date:</label><input class="field" type="date" name="expiration_date" required><br><br>
                <label>Credit holder name:</label><input class="field" type="text" name="holder_name" required><br><br>
                <label>Bank-issued:</label><input class="field" type="text" name="bank_name" required><br><br>
                <label>Credit Card Type:</label><br>
                <input type="radio" name="credit_type" value="Visa" required><label>Visa</label><br>
                <input type="radio" name="credit_type" value="Master_Card" required><label>Master Card</label><br><br>
                <input type="checkbox" name="accept" required> <label>I accept the contract terms and conditions</label><br><br>
                <label>Enter the First Name</label> <input class="field" type="text" name="name" required><br><br>
                <label>Enter the Date:</label><input class="field" type="date" name="date" required><br><br>
                <input type="submit" name="Confirm Rent" value="Confirm Rent" id="submitrent">
            </fieldset>
        </form>
    </main>
    </div>
<?php
    html_footer();
}
