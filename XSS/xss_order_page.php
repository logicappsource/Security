<?php
    //reflected XSS attack

    session_start();
    if(!isset($_SESSION["name"]))
        exit();
    

    if(isset($_GET["fruit"]))
        echo "Ok, we will send you ".$_GET["fruit"]." to your room";

?>

<p><form method="get">
    Please enter your favorite fruit for today:<br>
    <input type="text" name="fruit"><br>
    <input type="submit">
</form>