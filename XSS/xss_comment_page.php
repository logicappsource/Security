<?php
    //stored XSS attack

    session_start();
    if(!isset($_SESSION["name"]))
        exit();
    include "database.php";
    if(isset($_GET["comment"]))
    {
        $sql_r="INSERT INTO security.comments (id, text,user_name) VALUES (NULL, :text, :user)";
        //        echo $sql_r;
        $sth=$dbh->prepare($sql_r);

        $sth->bindParam(":text", $_GET["comment"]);
        $sth->bindParam(":user", $_SESSION["name"]);
        $sth->execute();
    }

    $sth=$dbh->query("SELECT * FROM security.comments");
    while($row = $sth->fetch( PDO::FETCH_ASSOC )){
        echo " Comment: " . $row['text'] . "<br>\n";
    }
?>
<form method="get">
    Please leave comments here:
    <textarea  name="comment"></textarea>
    <input type="submit">
</form>

