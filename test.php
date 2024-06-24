<?php
function x()
{
?>
    <form action="test.php" method="post">

        <input type="number" id="max_price" name="max_price" value="1000">
        <input type="submit" value="Search">
    </form>
<?php
}

if (!empty($_POST)) {
    echo $_POST["max_price"];
} else {
    x();
}
