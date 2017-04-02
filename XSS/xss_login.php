<?php
session_start();

include "database.php";
if(isset($_SESSION["name"]))
{
    LoggedIn();
}
else
{
    if(isset($_GET["login"]) and isset($_GET["password"]))
        DoLogin();
    else
        ShowLoginForm();
}
function ShowLoginForm()
{
    ?>
    <form>
        username: <input type="text" name="login"><br>
        password: <input type="text" name="password">
        <input type="submit">
    </form>

<?php
}

function DoLogin()
{
    global $dbh;
    $sql_query="select * from security.users where username=:user and password=:pass";

    $sth=$dbh->prepare($sql_query);

    $sth->bindParam(":user", $_GET["login"]);
    $sth->bindParam(":pass", $_GET["password"]);
    $sth->execute();
    $result=$sth->fetchAll();
    if(!empty($result))
    {
        $_SESSION["name"]=$result[0]["username"];
        LoggedIn();
    }
    else
        ShowLoginForm();

}

function LoggedIn()
{
    echo "You are now logged in as: ".$_SESSION["name"];
    echo "<p><a href='./xss_order_page.php'>Order page</a>";
    echo "<p><a href='./xss_comment_page.php'>Comments page</a>";
    echo "<p></p><p><a href='./xss_logout.php'>Log out</a>";

}


?>