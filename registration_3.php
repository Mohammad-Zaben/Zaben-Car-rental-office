<?php
require_once "db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = generateUniqueID();
    echo $id;
    $name = $_SESSION['name'];
    $address = $_SESSION['flat_house_no'] . ', ' . $_SESSION['street'];
    $city = $_SESSION['city'];
    $country = $_SESSION['country'];
    $datebirth = $_SESSION['DateOfBirth'];
    $idNumber = $_SESSION['idNumber'];
    $email = $_SESSION['email'];
    $telephone = $_SESSION['telephone'];
    $ccNumber = $_SESSION['ccNumber'];
    $ccExpDate = $_SESSION['ccExpDate'];
    $ccName = $_SESSION['ccName'];
    $ccBank = $_SESSION['ccBank'];
    $username = $_SESSION['username'];
    $password = $_SESSION["password"];

    $pdo = connect_database();
    $query = "INSERT INTO Users (UserID,Name,Address,City,Country,DateOfBirth,IDNumber,Email,Telephone,CreditCardNumber,CreditCardExpiration,CreditCardName,CreditCardBank,Username,Password)VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,md5(?))";
    $statement = $pdo->prepare($query);

    $statement->bindValue(1, $id);
    $statement->bindValue(2, $name);
    $statement->bindValue(3, $address);
    $statement->bindValue(4, $city);
    $statement->bindValue(5, $country);
    $statement->bindValue(6, $datebirth);
    $statement->bindValue(7, $idNumber);
    $statement->bindValue(8, $email);
    $statement->bindValue(9, $telephone);
    $statement->bindValue(10, $ccNumber);
    $statement->bindValue(11, $ccExpDate);
    $statement->bindValue(12, $ccName);
    $statement->bindValue(13, $ccBank);
    $statement->bindValue(14, $username);
    $statement->bindValue(15, $password);
    $x = md5($password);

    $done = $statement->execute();

    if ($done) {
        succsse($id);
    } else {
        echo "somthing wrong";
    }

    exit;
} else {



    html_header();
?>
    <main id="overmain">
        <br>
        <section>
            <h2>Confirm Your Information</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="formRent">
                <p>Name: <?php echo $_SESSION['name']; ?></p>
                <p>Address: <?php echo $_SESSION['flat_house_no'] . ', ' . $_SESSION['street']; ?></p>
                <p>Date of Birth: <?php echo $_SESSION['DateOfBirth']; ?></p>
                <p>ID Number: <?php echo $_SESSION['idNumber']; ?></p>
                <p>Email: <?php echo $_SESSION['email']; ?></p>
                <p>Telephone: <?php echo $_SESSION['telephone']; ?></p>
                <p>Credit Card Number: <?php echo $_SESSION['ccNumber']; ?></p>
                <p>Credit Card Expiration Date: <?php echo $_SESSION['ccExpDate']; ?></p>
                <p>Credit Card Name: <?php echo $_SESSION['ccName']; ?></p>
                <p>Credit Card Bank: <?php echo $_SESSION['ccBank']; ?></p>
                <p>Username: <?php echo $_SESSION['username']; ?></p>
                <input type="submit" value="Confirm" id="rent">
            </form>
        </section>
    </main>
<?php
    html_footer();
}
function succsse()
{
    session_destroy();
    header("Location:login.php");
    exit();
}

function generateUniqueID()
{
    // Generate a unique ID with additional entropy
    $uniqueID = uniqid(mt_rand(), true);

    // Remove non-numeric characters and ensure it is 10 digits long
    $uniqueID = substr(preg_replace("/[^0-9]/", "", $uniqueID), 0, 10);

    return $uniqueID;
}
