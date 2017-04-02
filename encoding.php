<?php
/*

ECB 
 */



$message="This is a secret message";
$secretKey="ThisIsASecretKey12345678";

$cipher_text_encoded=base64_encode(mcrypt_encrypt('tripledes',$secretKey,$message,'ecb'));


echo $cipher_text_encoded;

$cipher_text=base64_decode($cipher_text_encoded);

$plaintext=mcrypt_decrypt('tripledes',$secretKey,$cipher_text,'ecb');

echo $plaintext;



/*
 *
 * CBC
 *
$iv=mcrypt_create_iv(mcrypt_get_iv_size('tripledes','cbc'),MCRYPT_DEV_URANDOM);

$cipher_text_cbc=mcrypt_encrypt('tripledes',$secretKey,$message,'cbc',$iv);

$cipher_text_cbc_encoded=base64_encode($cipher_text_cbc);

echo $cipher_text_cbc_encoded;

$cipher_text_cbc=base64_decode($cipher_text_cbc_encoded);

$plain_text=mcrypt_decrypt('tripledes',$secretKey,$cipher_text_cbc,'cbc',$iv);

echo "<br>".$plain_text."<br>".$iv;
*/

/*
 *
 *
 * Listing all algorithms
 */

var_dump( mcrypt_list_algorithms("/usr/local/lib/libmcrypt"));
?>