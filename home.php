<?php
include "db.php";
include_once "Car.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();


if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
  html_header_loged();
else
  html_header();
if (isset($_SESSION["type"]) && $_SESSION["type"] == "Manager") {
  vewManaferNav();
} else {
  vewCustomerNav();
}
?>
<main>

  <p class="p">hello in zaben rent office</p>
</main>
</div>
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