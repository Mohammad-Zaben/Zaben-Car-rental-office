<?php
include "db.php";
include "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
$pdo = connect_database();
session_start();

// Default values


html_header_loged();
vewManaferNav();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $from_date = $_POST['from_date'] ?? null;
$to_date = $_POST['to_date'] ?? null;
$pickup_location = $_POST['pickup_location'] ?? null;
if (empty($pickup_location)) {
    // $return_location is empty or not set
    // You can set it to null if needed
    $pickup_location = null;
}
$return_date = $_POST['return_date'] ?? null;

$return_location = $_POST['return_location'] ?? null;
if (empty($return_location)) {
    // $return_location is empty or not set
    // You can set it to null if needed
    $return_location = null;
}

$status = $_POST['status'] ?? null;
    
    
    
    
    if (!$from_date && !$to_date && !$pickup_location && !$return_date && !$return_location && !$status) {
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d', strtotime('+1 week'));
}
    
    
    $query = "SELECT c.CarID, c.Type, c.Model, c.Description, c.Photo1, c.FuelType, c.Status 
          FROM Cars c 
          LEFT JOIN Reservations r ON c.CarID = r.CarID 
          WHERE 1=1";

// Add conditions dynamically based on input
if ($from_date && $to_date) {
    $query .= " AND (r.CarID IS NULL OR (r.StartDate > :to_date OR r.EndDate < :from_date))";
}
if ($pickup_location) {
    $query .= " AND c.PickUpLocation = :pickup_location";
}
if ($return_date) {
    $query .= " AND r.EndDate = :return_date";
}
if ($return_location) {
    $query .= " AND r.DropoffLocationID = (SELECT LocationID FROM Locations WHERE Name = :return_location)";
}
if ($status) {
    $query .= " AND c.Status = :status";
}

   $stmt = $pdo->prepare($query);

// Bind parameters
if ($from_date && $to_date) {
    $stmt->bindValue(':from_date', $from_date);
    $stmt->bindValue(':to_date', $to_date);
}
if ($pickup_location) {
    $stmt->bindValue(':pickup_location', $pickup_location);
}
if ($return_date) {
    $stmt->bindValue(':return_date', $return_date);
}
if ($return_location) {
    $stmt->bindValue(':return_location', $return_location);
}
if ($status) {
    $stmt->bindValue(':status', $status);
}

$stmt->execute();
$result = $stmt->fetchAll();

    displayForm();
    displayTableResult($result);
} else {
    // Default query to show all available cars for a week from the current date
    $sql = "SELECT * FROM Cars";

    $result = $pdo->query($sql);
    $results = $result->fetchAll();

    displayForm();
    displayTableResult($results);
}

function displayForm()
{
     $pdo = connect_database();
     $location_query = "SELECT Name FROM Locations";
    $stmt = $pdo->query($location_query);
    $locations = $stmt->fetchAll();
?>
<main>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="formRent">
        <label class="lable" for="from_date">From Date:</label>
        <input class="field" type="date" id="from_date" name="from_date"><br><br>
        
        <label class="lable" for="to_date">To Date:</label>
        <input class="field" type="date" id="to_date" name="to_date"><br><br>
        
        <label class="lable" for="pickup_location">Pick-Up Location:</label>
        <select class="field" id="pickUpLocation" name="pickUpLocation">
            <option value="">select Location</option>
                    <?php foreach ($locations as $location) { ?>
                        <option value="<?php echo $location['Name']; ?>">
                            <?php echo $location['Name']; ?>
                        </option>
                    <?php } ?>
                </select><br><br>
        
        <label class="lable" for="return_date">Return Date:</label>
        <input class="field" type="date" id="return_date" name="return_date"><br><br>
        
        <label class="lable" for="return_location">Return Location:</label>
        <select class="field" id="return_location" name="return_location">
             <option value="">select Location</option>
                    <?php foreach ($locations as $location) { ?>
                        <option value="<?php echo $location['Name']; ?>">
                            <?php echo $location['Name']; ?>
                        </option>
                    <?php } ?>
                </select><br><br>
        
        
        <label class="lable" for="status">Status:</label>
        <select class="field" id="status" name="status">
            <option value="">Any</option>
            <option value="available">Available</option>
            <option value="repair">In Repair</option>
            <option value="damage">Damaged</option>
        </select><br><br>
        
        <button type="submit">Search</button>
    </form>
    
<?php
}

function displayTableResult($results)
{
?>
    <table class="content-table" id="inv">
        <thead>
            <tr>
                <th>Car ID</th>
                <th>Type</th>
                <th>Model</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Fuel Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) { ?>
                <tr>
                    <td><?php echo $row['CarID']; ?></td>
                    <td><?php echo $row['Type']; ?></td>
                    <td><?php echo $row['Model']; ?></td>
                    <td><?php echo $row['Description']; ?></td>

                    <td><figure><img src="images/<?php echo $row['Photo1']; ?>" alt="Photo1" width=160>
                    <figcaption><?php echo $row['Model'];  ?></figcaption></figure></td>

                    <td><?php echo $row['FuelType']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
            </main>
            </div>
<?php
}
html_footer();
?>