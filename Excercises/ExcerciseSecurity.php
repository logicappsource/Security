<?php

    //with 20 chars.. 
/*$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
                 */

    //generate string with 20 chars
$seed = str_split('gqrxyz'
                 .'ABCDEFGZ'
                 .'01967482'); // and any other characters


shuffle($seed); // probably optional since array_is randomized; this may be redundant
$rand = '';


$arrayRandom =  array();

for($i = 1;  $i <= 50; $i++) {//Generate 500k strings 

    array_push($arrayRandom, $i);

            foreach (array_rand($seed, 20) as $k) $rand .= $seed[$k];
            
                array_push($arrayRandom,$seed);
}

    print_r($arrayRandom);

$aDecode = json_encode($arrayRandom);
$save = file_put_contents('array2.json', $aDecode);


?> 