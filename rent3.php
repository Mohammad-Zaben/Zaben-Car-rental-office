<?php
include "db.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();

if (!isset($_SESSION['token'])) {
    // Generate a new token
    $token = bin2hex(random_bytes(32));

    // Store the token in the session
    $_SESSION['token'] = $token;
    $pdo = connect_database();

    $pic_loc = $_SESSION["pickup_location"];
    $query = "SELECT LocationID FROM Locations where Name = '$pic_loc' ";
    $result = $pdo->query($query);
    $pic_loc_id = $result->fetchColumn();

    $re_loc = $_SESSION["Return_location"];
    $query = "SELECT LocationID FROM Locations where Name = '$re_loc' ";
    $result = $pdo->query($query);
    $re_loc_id = $result->fetchColumn();



    $user_id = $_SESSION["userid"];
    $car_id = $_SESSION["car_id"];
    $start_date = $_SESSION["from_date"];
    $end_date = $_SESSION["to_date"];
    $total_price = $_SESSION["total_rent_amount"];


    $query = "INSERT INTO Reservations (UserID,CarID,StartDate,EndDate,TotalPrice,PickupLocationID,DropoffLocationID)VALUE(?,?,?,?,?,?,?)";
    $statement = $pdo->prepare($query);

    $statement->bindValue(1, $user_id);
    $statement->bindValue(2, $car_id);
    $statement->bindValue(3, $start_date);
    $statement->bindValue(4, $end_date);
    $statement->bindValue(5, $total_price);
    $statement->bindValue(6, $pic_loc_id);
    $statement->bindValue(7, $re_loc_id);

    $done = $statement->execute();

    if ($done) {
        $query_2 = "DELETE FROM Caruserstatus WHERE CarID = $car_id AND UserID = $user_id;";
        $result = $pdo->query($query_2);

        $query_2 = "INSERT INTO Caruserstatus (CarID, UserID, Status) VALUES ($car_id, $user_id, 'rented')";
        $result = $pdo->query($query_2);


        $inc_id = create_invice();

        html_header_loged();
        if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
            vewManaferNav();
        } else {
            vewCustomerNav();
        }
?>
        <main>
            <p class='p'>Thank you for dealing with us</p>
            <p class='p'>Your rent process has been completed successfully</p>
            <p class='p'>the invoice ID is : <?php echo $inc_id ?></p>
        </main>
    </div>
<?php
        html_footer();
        exit();
    } else {
        echo "somthing wrong";
        exit();
    }
} else {
    html_header_loged();
    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }
    echo "<p class='p'>Item already created. Please do not refresh the page.</p> </div>";
    html_footer();
    exit();
}



function create_invice()
{
    $query = "INSERT INTO Invoices (InvoiceID,InvoiceDate, CustomerID, CustomerName, CustomerAddress, CustomerTelephone, CarID, CarModel, CarType, FuelType, PickUpDate, PickUpLocation, ReturnDate, ReturnLocation, Insurance, BabySeats, TotalAmount) VALUES (:invoice_id,:invoice_date, :customer_id, :customer_name, :customer_address, :customer_telephone, :car_id, :car_model, :car_type, :fuel_type, :pick_up_date, :pick_up_location, :return_date, :return_location, :insurance, :baby_seats, :total_amount)";

    // Get the user information from the database
    $pdo = connect_database();
    $user_id = $_SESSION['userid'];
    $user_query = "SELECT * FROM Users WHERE UserID = :user_id";
    $user_stmt = $pdo->prepare($user_query);
    $user_stmt->execute(['user_id' => $user_id]);
    $user = $user_stmt->fetch();

    // Get the car information from the database
    $car_id = $_SESSION['car_id'];
    $car_query = "SELECT * FROM Cars WHERE CarID = :car_id";
    $car_stmt = $pdo->prepare($car_query);
    $car_stmt->execute(['car_id' => $car_id]);
    $car = $car_stmt->fetch();

    $inv_id = generateUniqueID();

    // Bind parameters and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'invoice_id' => $inv_id,
        'invoice_date' => date('Y-m-d'),
        'customer_id' => $user['UserID'],
        'customer_name' => $user['Name'],
        'customer_address' => $user['Address'],
        'customer_telephone' => $user['Telephone'],
        'car_id' => $car['CarID'],
        'car_model' => $car['Model'],
        'car_type' => $car['Type'],
        'fuel_type' => $car['FuelType'],
        'pick_up_date' => $_SESSION['from_date'],
        'pick_up_location' => $_SESSION['pickup_location'],
        'return_date' => $_SESSION['to_date'],
        'return_location' => $_SESSION['Return_location'],
        'insurance' => $_SESSION['insurance'] ,
        'baby_seats' => $_SESSION['baby_seats'],
        'total_amount' => $_SESSION['total_rent_amount']
    ]);

    return $inv_id;
}

function generateUniqueID()
{
    // Generate a unique ID with additional entropy
    $uniqueID = uniqid(mt_rand(), true);
    // Remove non-numeric characters and ensure it is 10 digits long
    $uniqueID = substr(preg_replace("/[^0-9]/", "", $uniqueID), 0, 10);
    return $uniqueID;
}
