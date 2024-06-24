<?php
define('DBHost', 'localhost');
define('DBName', 'car-rental-office');
define('DBUser', 'web1202068_dbuser');
define('PASS', '1202068');


function connect_database()
{
    try {

        $pdo = new PDO("mysql:host=" . DBHost . ";dbname=" . DBName, DBUser, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function error_message($msg)
{

    echo "<p><em> error $msg</em></p>";
    html_footer();
    exit;
}

function html_header()
{
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="pragma" content="no-cache" />
        <title>Zaben car rental office</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <h1>
                <img src="images/Zaben Office.png" alt="Zaben car rental office" width="100" class="car-logo" /> Zaben car rental office
            </h1>
            <nav id="navbar">
                <ul>
                    <li><a href="home.php" class="navbar">Home</a></li>
                    <li><a href="registration_1.php" class="navbar">Sign Up</a></li>
                    <li><a href="login.php" class="navbar">log in</a></li>
                    <li><a href="contant.php">Contact Us</a></li>
                    <li><a href="about.php">About</a></li>

                </ul>
            </nav>
        </header>


    <?php

}


function html_header_loged()
{
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="pragma" content="no-cache" />
            <title>Zaben car rental office</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <header>
                <h1>
                    <img src="images/Zaben Office.png" alt="Zaben car rental office" width="100" class="car-logo" /> Zaben car rental office
                </h1>
                <nav id="navbar">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="contant.php">Contact Us</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                </nav>
            </header>


        <?php

    }

    function html_footer()
    {
        ?>
            <footer>
                <section class="footer-section">
                    <p>the last update in: <time datetime="2024-07-03">7/5/2024</time></p>
                    <p>Our address is Ramallah, Al-Ersal Street</p>
                </section>
                <section class="footer-section">
                    <a href="contact.html">Contact us</a>
                    <p>
                        email:
                        <a href="mailto:mohammad.nail.zaben@gmail.com">mohammad.nail.zaben@gmail.com</a>
                    </p>
                    <p>Phone: 0597370661</p>
                </section>
                <section class="footer-section">
                    <img src="images/Zaben Office.png" alt="Zaben car rental office" width="80" />
                    <p>&copy; 2024 Zaben Car Rental Office. All rights reserved.</p>
                </section>
            </footer>
        </body>

        </html>
    <?php
    }
