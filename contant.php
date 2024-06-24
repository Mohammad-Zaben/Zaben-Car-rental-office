<?php
include "db.php";
include "Car.php";
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true)
    html_header_loged();
else
    html_header();

?>
<div class="form-container">
  <form action="send_email.php" method="post" class="form-group">
    <div class="form-group">
      <label for="name">Your Name:</label>
      <input type="text" id="name" name="name" required />
    </div>
    <div class="form-group">
      <label for="email">Your Email:</label>
      <input type="email" id="email" name="email" required />
    </div>
    <div class="form-group">
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" required />
    </div>
    <div class="form-group">
      <label for="message">Message:</label>
      <textarea id="message" name="message" required></textarea>
    </div>
    <div class="form-group">
      <button type="submit">Send Email</button>
    </div>
  </form>
</div>
<?php
html_footer();