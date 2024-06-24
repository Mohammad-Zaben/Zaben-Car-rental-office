<?php
require_once "db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store data in session
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['flat_house_no'] = $_POST['flat_house_no'];
    $_SESSION['street'] = $_POST['street'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['DateOfBirth'] = $_POST['DateOfBirth'];
    $_SESSION['idNumber'] = $_POST['idNumber'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['telephone'] = $_POST['telephone'];
    $_SESSION['ccNumber'] = $_POST['ccNumber'];
    $_SESSION['ccExpDate'] = $_POST['ccExpDate'];
    $_SESSION['ccName'] = $_POST['ccName'];
    $_SESSION['ccBank'] = $_POST['ccBank'];

    header('Location: registration_2.php');
    exit();
}

html_header();
?>
<main>
    <form action=<?php echo $_SERVER["PHP_SELF"] ?> id method="post" class="formRent">
        <fieldset class="fildste">
            <legend class="legend">Regestration Form:</legend>
            <label class="lable">Name:</label>
            <input class="field" type="text" name="name" required> <br><br>

            <label class="lable" for="flat_house_no">Flat/House No:</label>
            <input class="field" type="text" name="flat_house_no" required><br><br>

            <label class="lable" for="street">Street:</label>
            <input class="field" type="text" name="street" required><br><br>

            <label class="lable" for="city">City:</label>
            <input class="field" type="text" name="city" required><br><br>

            <label class="lable" for="country">Country:</label>
            <input class="field" type="text" name="country" required><br><br>

            <label class="lable" for="DateOfBirth">Date of Birth:</label>
            <input class="field" type="date" name="DateOfBirth" required><br><br>

            <label class="lable" for="id number">ID Number</label>
            <input class="field" type="number" name="idNumber" required><br><br>

            <label class="lable" for="email">Email</label>
            <input class="field" type="email" name="email" required><br><br>

            <label class="lable" for="telephon">telefon numbber</label>
            <input class="field" type="number" name="telephone" required><br><br>

            <label class="lable">Credit Card Number: </label>
            <input class="field" type="text" name="ccNumber" required><br><br>

            <label class="lable">Credit Card Expiration Date: </label>
            <input class="field" type="date" name="ccExpDate" required><br><br>

            <label class="lable">Credit Card Name: </label>
            <input class="field" type="text" name="ccName" required><br><br>

            <label class="lable">Credit Card Bank: </label>
            <input class="field" type="text" name="ccBank" required><br>

            <input type="submit" value="next" id="rent"></input>
        </fieldset>
    </form>
</main>

<?php
html_footer();
