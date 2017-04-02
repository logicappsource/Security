<?php
/*
//--------------------------------------------------------------------------------------------------> 
//--------------------------------------------------------------------------------------------------> 
//*Electronic Codebook -> ! Encrypts every block - INdivdually -------------------------------------> 
//--------------------------------------------------------------------------------------------------> 
*/

/*************** Example 1 ********************/ 
$message="This is a secret message";
$secretKey="ThisIsASecretKey12345678";

//Base 64 Encryption 
$cipher_text_encoded=base64_encode(mcrypt_encrypt('tripledes',$secretKey,$message,'ecb'));


    echo 'This is Cipher Text Encoded    = '. $cipher_text_encoded. '<br/>';     //Output Encoded string

//Decode Base 64 
$cipher_text=base64_decode($cipher_text_encoded);

$plaintext=mcrypt_decrypt('tripledes',$secretKey,$cipher_text,'ecb');

    echo 'MESSAGE DECODED = '. $plaintext. '<br/>';  //Output decoded message
 
//--------------------------------------------------------------------------------------------------> 
//--------------------------------------------------------------------------------------------------> 
///*************** Example 2 ********************/ -------------------------------------------------> 
//--------------------------------------------------------------------------------------------------> 
/*
$newMessage="mySecretMessage"; 
$newSecretKey="Thisisnewsecretkey1234";

//New Base64 Encryption 
$newCipher_text_encoded=base64_encode(mcrypt_encrypt('tripledes',$newSecretKey,$newMessage,'ecb'));

    echo  $newCipher_text_encoded;

//Decode Base64 

$newCipher_text=base64_decode($newCipher_text);
$newPlainText=mcrypt_decrypt('tripledes',$newSecretKey,$newMessage,'ecb');

    echo $newPlainText;
*/


//--------------------------------------------------------------------------------------------------> 
//--------------------------------------------------------------------------------------------------> 
//**************CBC **************** Use the previous Cypher blocks to Encrypt the next one 
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------> */


 //ENCODE 
$iv=mcrypt_create_iv(mcrypt_get_iv_size('tripledes','cbc'),MCRYPT_DEV_URANDOM);

$cipher_text_cbc=mcrypt_encrypt('tripledes',$secretKey,$message,'cbc',$iv);

$cipher_text_cbc_encoded=base64_encode($cipher_text_cbc);

    echo '<br/> This is CBC encoded '. $cipher_text_cbc_encoded;

    //DECODE 

$cipher_text_cbc=base64_decode($cipher_text_cbc_encoded);

$plain_text=mcrypt_decrypt('tripledes',$secretKey,$cipher_text_cbc,'cbc',$iv);

    echo "<br>".$plain_text."<br>".$iv;


/*
 
 * Listing all algorithms
 */

//var_dump( mcrypt_list_algorithms("/usr/local/lib/libmcrypt"));
?>