<?php
require_once "db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    $username = $_POST['username'];
    if ( strlen($username) > 13) {
        $error = "Username must be between 6 and 13 characters.";
        echo $error;
    }

    // Validate password
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (strlen($password) < 4 || strlen($password) > 12) {
        $error = "Password must be between 8 and 12 characters.";
        echo $error;
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
        echo $error;
    }

    if (!isset($error)) {
        // Store data in session
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password; // Note: Passwords should be hashed before storing

        header('Location: registration_3.php');
        exit();
    }
}
html_header();
?>

    <main id="overmain">
        <br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="formRent">
            <label class="lable">Username:</label>
            <input class="field" type="text" name="username" required> <br><br>

            <label class="lable">Password:</label>
            <input class="field" type="password" name="password" required> <br><br>

            <label class="lable">Confirm Password:</label>
            <input class="field" type="password" name="confirm_password" required> <br><br>

            <input type="submit" value="Next" id="rent">
        </form>
    </main>

<?php
html_footer();
