<?php
/*
The scenario mentioned above is also true with PHP technology. For instance,
 if a user requests a personal data file from the server, it will be validated by appending ‘
 .DAT’ extension to the filename. This script itself appears to be secure by enforcing the file extension but the request 
 for the resource can be manipulated by appending a “%00” null byte at the end of URL. 
 Thus, a malicious adversary can take advantage of this vulnerability to read almost any system file through a simple browser.
Null Byte Injection

Null Byte Injection is an active exploitation technique used to bypass sanity checking filters in web infrastructure by adding URL-encoded null byte characters (i.e. %00, or 0x00 in hex) to the user-supplied data. This injection process can alter the intended logic of the application and allow malicious adversary to get unauthorized access to the system files.

 

Most web applications today are developed using higher-level languages such as, PHP, ASP, Perl, and Java. However, these web applications at some point require processing of high-level code at system level and this process is usually accomplished by using ‘C/C++’ functions. The diverse nature of these dependent technologies has resulted in an attack class called ‘Null Byte Injection’ or ‘Null Byte Poisoning’ attack. In C/C++, a null byte represents the string termination point or delimiter character which means to stop processing the string immediately. Bytes following the delimiter will be ignored. If the string loses its null character, the length of a string becomes unknown until memory pointer happens to meet next zero byte. This unintended ramification can cause unusual behavior and introduce vulnerabilities within the system or application scope. In similar terms, several higher-level languages treat the ‘null byte’ as a placeholder for the string length as it has no special meaning in their context. Due to this difference in interpretation, null bytes can easily be injected to manipulate the application behavior.

 

URLs are limited to a set of US-ASCII characters ranging from 0x20 to 0x7E (hex) or 32 to 126 (decimal)[5][8]. However, the aforementioned range uses several characters that are not permitted because they have special meaning within HTTP protocol context. For this reason, the URL encoding scheme was introduced to include special characters within URL using the extended ASCII character representation. In terms of “null byte”, this is represented as %00 in hexadecimal. The scope of a null byte attack starts where web applications interact with active ‘C’ routines and external APIs from the underlying OS. Thus, allowing an attacker to manipulate web resources by reading or writing files based on the application's user privileges.

 

Let’s take some examples to demonstrate a real-world attack:

*/


$file = $_GET['file'];

require_once("/var/www/images/$file.dat");

 
/*
Exploitation more info here :
Normal Mode: http://www.example.host/user.php?file=myprofile.dat
Attacking Mode: http://www.example.host/user.php?file=../../../etc/passwd%00
*/
?>