<?php 
/*
	This is a simple proof of concept of a brute force algorithm for string matching with
	given set of characters.
    
	The way this works is that the algorithm counts from first to last possible combination of 
	given characters. 

	Instead of counting(incrementing) in number base 10 we use 
	a new base which is derived from your set of possible characters (we count in symbols).
	So if your characters list contains 27 characters the program actually counts in a 27 base
	number system.

    */

//Set Max String and length and chartset - Generating combinations 
$maxLenght = 7; 
$charSet = "abdefgh12345";

$size = strlen($charSet); //12
$base = array();  

$counter = 0; 
$baseSize = 1; 

// Let's see how many combinations exist for the given length and charset
$combinations = 0; 

for($i=1; $i<= $maxLenght;$i++) {
    $combinations += pow($size, $i);
}  
 echo "There are the $combinations possibe combinations <br/><br/>";  // possible combinations 

//While for for for if 
while($baseSize <= $maxLenght) {
        //Go through all possible combinations and last char and output $base 
        for($i = 0; $i < $size; $i++){
            $base[0] = $i;

                for($j = $baseSize; $j>=0; $j-- ) {
                    echo $charSet[$base[$j]];
                }
                echo '<br/>'. "Possible combination = ". $counter;
            }

        //How many $base elements reach their maxium ? 
            for($i= 0; $i<$baseSize; $i++) {
                if($base[i] == $size -1) $counter++;
                else break;
            }

            //Every array element reached their maximum value? expand array and set value = 0; 
            if($counter == $baseSize) {
                
                    for ($i = 0; $i<= $baseSize; $i++){
                        //Notice <=$baseSize Initalize 0 values to all existing array elements and ADD 1 more element with that value 
                        $base[i] = 0; 
                    }
                        $baseSize = count($base);
             }
             //Carry one 
             else {
                    $base[$counter]++;
                    for($i = 0; $i < $counter; $i++) $base[$i] = 0;
             }
             $counter = 0; 

}


?> 