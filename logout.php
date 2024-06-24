<?php
include "db.php";
include "type/customer/customerNav.php";
include "type/manager/managerNav.php";
session_start();
html_header();

vewCustomerNav();

echo "<main>";
echo "<p class='p'>Have a Nice Day...... </p>";
echo "</main>";
echo "</div>";
html_footer();
session_destroy();
