<pre>
<?php
/*
echo hash("md5", "Hello World!")."\n";
echo hash("md5", "Hello world!");
*/
/*
echo hash("sha1","Password123!");
*/
/*
$password="123456";
$salt=rand(0,100);
$hashed=hash("sha256", $password.$salt);
echo $hashed."\n";


if (@hash("sha256",$_GET["password"].$salt)==$hashed)
    echo "password OK";
else
    echo "Something is worng";
*/
/*
$password="123456";

$salt=base64_encode(mcrypt_create_iv(16,MCRYPT_DEV_URANDOM));
$pepper="ThisIs a sdæfkjglsfjdhleqrbh 3204i9245m";

$hashed=hash("sha256", $password.$pepper.$salt);
echo $hashed."\n";


if (@hash("sha256",$_GET["password"].$pepper.$salt)==$hashed)
    echo "password OK";
else
    echo "Something is worng";

echo "\n".$salt;
*/
$password="123456";

$pepper="ThisIs a sdæfkjglsfjdhleqrbh 3204i9245m";

$options=["cost"=>15];
$hashed=password_hash($password.$pepper,PASSWORD_DEFAULT,$options);
echo $hashed."\n";


if (@password_verify($_GET["password"].$pepper,$hashed))
    echo "password OK";
else
    echo "Something is worng";

?>

</pre>