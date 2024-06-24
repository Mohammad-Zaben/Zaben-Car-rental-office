<?php include "db.php";
include "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
$pdo = connect_database();
session_start();

if (isset($_SESSION["userid"])) {
    $user_id = $_SESSION["userid"];
    $query = "SELECT r.ReservationID AS InvoiceID, r.StartDate AS InvoiceDate, c.Type AS CarType, c.Model AS CarModel,
r.StartDate AS PickupDate, l1.Name AS PickupLocation, r.EndDate AS ReturnDate, l2.Name AS ReturnLocation 
FROM Reservations r JOIN Cars c ON r.CarID = c.CarID JOIN Locations l1 ON r.PickupLocationID = l1.LocationID 
JOIN Locations l2 ON r.DropoffLocationID = l2.LocationID WHERE r.UserID = $user_id ORDER BY r.StartDate DESC;";
    $result = $pdo->query($query);

    html_header_loged();

    if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
        vewManaferNav();
    } else {
        vewCustomerNav();
    }

    echo "<main>";
    echo "<table class='content-table'>";
    echo "<thead>";
    echo "<tr>
        <th>Invoice ID</th>
        <th>Invoice Date</th>
        <th>Car Type</th>
        <th>Car Model</th>
        <th>Pickup Date</th>
        <th>Pickup Location</th>
        <th>Return Date</th>
        <th>Return Location</th>
    </tr>";
    echo "</thead>";

    while ($row = $result->fetch()) {
        echo "<tr>";
        echo "<td>" . $row['InvoiceID'] . "</td>";
        echo "<td>" . $row['InvoiceDate'] . "</td>";
        echo "<td>" . $row['CarType'] . "</td>";
        echo "<td>" . $row['CarModel'] . "</td>";
        echo "<td>" . $row['PickupDate'] . "</td>";
        echo "<td>" . $row['PickupLocation'] . "</td>";
        echo "<td>" . $row['ReturnDate'] . "</td>";
        echo "<td>" . $row['ReturnLocation'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
    echo "</div>";



    html_footer();
} else {
    header("Location: login.php");
}
