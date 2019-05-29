On the server which runs the PHP the files needed are 'handler.php' and 'geoplugin.class.php' 
these files need to be in the same directory
In the file handler.php, on line 22 where there is this line of code 
$send_to = 'ENTER EMAIL TO SEND TO';
change ENTER EMAIL TO SEND TO to your desired email address, 
that is the email address where the details are sent.

 
In the index-home.html page on line 766 is the URL where the data is being send to 
You will see this line of code
url: 'handler.php', 
as per the current file its 'handler.php' change that to your URL.
Use an absolute URL eg http://example.com/handler.php
if the index.html, index-home.html, handler.php and geoplugin.class.php are in the same directory,
leave the line of code 
url: 'handler.php', 
in index-home.html the way it is

To access the page... you acces using the index.html file

Open files using notepad++;


