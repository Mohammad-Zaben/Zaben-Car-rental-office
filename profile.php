<?php include "db.php";
session_start();
$pdo = connect_database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    global $pdo;
    $user_id = $_SESSION["userid"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $birthDate = $_POST["birthDate"];
    $idnumber = $_POST["idnumber"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $creditcardnumber = $_POST["creditcardnumber"];
    $creditcardexpiration = $_POST["creditcardexpiration"];
    $creditcardname = $_POST["creditcardname"];
    $creditcardbank = $_POST["creditcardbank"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "UPDATE Users SET 
                Name = '$name', 
                Address = '$address', 
                City = '$city', 
                Country = '$country', 
                DateOfBirth = '$birthDate', 
                IDNumber = $idnumber, 
                Email = '$email', 
                Telephone = $telephone, 
                CreditCardNumber = $creditcardnumber, 
                CreditCardExpiration = '$creditcardexpiration', 
                CreditCardName = '$creditcardname', 
                CreditCardBank = '$creditcardbank', 
                Username = '$username', 
                Password = md5('$password')
                where UserID = $user_id ";

    $result = $pdo->query($query);

    if ($result) {
     
        html_header_loged();
        displayform();
        html_footer();
    } else {
        echo "Error updating profile.";
    }
} else {
    html_header_loged();
    displayform();
    html_footer();
}

function displayform()
{
    global $pdo;
    $user_id = $_SESSION["userid"];
    $query = "SELECT * FROM Users where UserId= $user_id";
    $result = $pdo->query($query);
    $user = $result->fetch();
?>
<div class="form-container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="formRent">
        <fieldset>
            <legend>Profile:</legend>
            <label class="lable">User ID: </label><input class="field" type="number" name="user_id" value="<?php echo $user["UserID"] ?>" disabled> <br /><br />
            <label class="lable">Name: </label><input class="field" type="text" name="name" value="<?php echo $user["Name"] ?>"> <br /><br />
            <label class="lable">Address: </label><input class="field" type="text" name="address" value="<?php echo $user["Address"] ?>"> <br /><br />
            <label class="lable">City: </label><input class="field" type="text" name="city" value="<?php echo $user["City"] ?>"> <br /><br />
            <label class="lable">Country: </label><input class="field" type="text" name="country" value="<?php echo $user["Country"] ?>"> <br /><br />
            <label class="lable">Date of Birth: </label><input class="field" type="date" name="birthDate" value="<?php echo $user["DateOfBirth"] ?>"> <br /><br />
            <label class="lable">ID Number: </label><input class="field" type="text" name="idnumber" value="<?php echo $user["IDNumber"] ?>"> <br /><br />
            <label class="lable">Email: </label><input class="field" type="email" name="email" value="<?php echo $user["Email"] ?>"> <br /><br />
            <label class="lable">Telephone: </label><input class="field" type="text" name="telephone" value="<?php echo $user["Telephone"] ?>"> <br /><br />
            <label class="lable">Credit Card Number: </label><input class="field" type="text" name="creditcardnumber" value="<?php echo $user["CreditCardNumber"] ?>"> <br /><br />
            <label class="lable">Credit Card Expiration: </label><input class="field" type="date" name="creditcardexpiration" value="<?php echo $user["CreditCardExpiration"] ?>"> <br /><br />
            <label class="lable">Credit Card Name: </label><input class="field" type="text" name="creditcardname" value="<?php echo $user["CreditCardName"] ?>"> <br /><br />
            <label class="lable">Credit Card Bank: </label><input class="field" type="text" name="creditcardbank" value="<?php echo $user["CreditCardBank"] ?>"> <br /><br />
            <label class="lable">Username: </label><input class="field" type="text" name="username" value="<?php echo $user["Username"] ?>"> <br /><br />
            <label class="lable">Password: </label><input class="field" type="password" name="password" value="<?php echo $user["Password"] ?>"> <br /><br />
            <input type="submit" name="update" value="Update Profile">
        </fieldset>
    </form>
    </div>
<?php
}
