<?php
include "db.php";
include "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";

session_start();
$pdo = connect_database();


$query = "SELECT c.CarID AS CarReferenceNumber, c.Make AS CarMake, 
c.Type AS CarType, c.Model AS CarModel, r.StartDate AS PickupDate,
r.EndDate AS ReturnDate, l.Name AS ReturnLocation, u.Name AS CustomerName, u.UserID  AS UserID FROM Reservations
r JOIN Cars c ON r.CarID = c.CarID JOIN Caruserstatus cus ON c.CarID = cus.CarID JOIN Locations l 
ON r.DropoffLocationID = l.LocationID JOIN Users u ON r.UserID = u.UserID WHERE cus.Status = 'returning';";

$result = $pdo->query($query);
html_header_loged();
if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
    vewManaferNav();
} else {
    vewCustomerNav();
}

displat_table($result);
html_footer();
function displat_table($result)
{

?>
    <main>
        <table class="content-table">

            <thead>

                <tr>
                    <th>Car Reference Number</th>
                    <th>Car Make</th>
                    <th>Car Type</th>
                    <th>Car Model</th>
                    <th>Pickup Date</th>
                    <th>Return Date</th>
                    <th>Return Location</th>
                    <th>Customer Name</th>
                    <th>return car form</th>
                </tr>
            </thead>
            <tbody>
            <?php

            while ($row = $result->fetch()) {
                $x = $row["CarReferenceNumber"];
                echo "<tr>";
                echo "<th>" . (isset($row["CarReferenceNumber"]) ? $row["CarReferenceNumber"] : "") . "</th>";
                echo "<th>" . (isset($row["CarMake"]) ? $row["CarMake"] : "") . "</th>";
                echo "<th>" . (isset($row["CarType"]) ? $row["CarType"] : "") . "</th>";
                echo "<th>" . (isset($row["CarModel"]) ? $row["CarModel"] : "") . "</th>";
                echo "<th>" . (isset($row["PickupDate"]) ? $row["PickupDate"] : "") . "</th>";
                echo "<th>" . (isset($row["ReturnDate"]) ? $row["ReturnDate"] : "") . "</th>";
                echo "<th>" . (isset($row["ReturnLocation"]) ? $row["ReturnLocation"] : "") . "</th>";
                echo "<th>" . (isset($row["CustomerName"]) ? $row["CustomerName"] : "") . "</th>";
                echo "<th> <button id='rent'><a href='returnform.php?car_id=" . $row["CarReferenceNumber"] . '&' . 'user_id=' . $row["UserID"] . "'>show return form</a></button></th>";


                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</main>";

            echo "</div>";
        }
