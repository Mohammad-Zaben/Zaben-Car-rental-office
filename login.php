<?php
session_start();
include "db.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
$PHP_SELF = $_SERVER['PHP_SELF'];
if (isset($_GET["car_id"]))
    $car_idd = $_GET["car_id"];


do_authentication1();

function do_authentication1()
{
    global $PHP_SELF;

    if (!isset($_POST['username'])) {
        login_form();
        exit;
    } else {

        $_SESSION['userpassword'] = $_POST['userpassword'];
        $_SESSION['username'] = $_POST['username'];
        $username = $_POST['username'];
        $userpassword = $_POST['userpassword'];
        $pdo = connect_database();
        if (!$pdo) error_message("Null PDO Object");
        $query = "SELECT  COUNT(*) FROM Users WHERE Username = '$username' AND Password= md5('$userpassword')";
        $result = $pdo->query($query);
        if ($result->fetchColumn() == 0) {
            header("Location: login.php");
        } else {
            // $query = "SELECT Password FROM users WHERE Username = '$username' AND Password= md5('userpassword')";
            // $result = $pdo->query($query);
            // $pass = $result->fetch();
            // echo md5($userpassword);

            //  if ($pass["Password"] == md5($userpassword)) {
            $_SESSION['logged_in'] = True;
            $query = "SELECT UserID,Type FROM Users WHERE Username = '$username'";
            $result = $pdo->query($query);
            $userid = $result->fetch();
            $_SESSION["userid"] = $userid["UserID"];
            $_SESSION["type"] = $userid["Type"];
            // $query = "SELECT Type FROM users WHERE UserName = '$username'";
            // $result = $pdo->query($query);
            // $pos = $result->fetch()['userposition'];
            // if ($pos == 'Customer')
            //     $_SESSION['type'] = 1;
            // elseif ($pos == 'Maneger')
            //     $_SESSION['type'] = 2;
            if (isset($_SESSION["do_new_reant"])) {
                $car_id = $_SESSION["car_id"];
                header("Location: rent.php?action=view&car_id=$car_id");
            } else {
                header("Location: search.php");
            }
            // }
        }
    }
}

function login_form()
{
    global $PHP_SELF;
    global $car_idd;
    $_SESSION["car_id"] = $car_idd;
    html_header();

?>
    <div id="overmain">
        <main>

            <div class="login-container">
                <h1>Login</h1>
                <form method="POST" action="<?php echo "$PHP_SELF"; ?>">
                    <div class="input-container">
                        <img src="images/userblack.png" alt="Username Icon" />
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="input-container">
                        <img src="images/passblack.png" alt="Password Icon" />
                        <input type="password" placeholder="Password" name="userpassword" required />
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>

        </main>
    </div>
    <?php html_footer() ?>
<?php
}

?>