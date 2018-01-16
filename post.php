<!-- This file is for the chat functionality.

Start the post.php file with the session_start() function as we will be using the session of the user's name in this file.
Using the isset boolean, we check if the session for 'name' exists before doing anything else.
Then grab the POST data that was being sent to this file by jQuery. We store this data into the $text variable.
This data, as will all overall user input data, will be stored on the log.html file. To do this we open the file with the mode on the fopen function to 'a', which according to php.net opens the file for writing only; places the file pointer at the end of the file. If the file does not exist, attempt to create it. We then write our message to the file using the fwrite() function.
The message we will be writing will be enclosed inside the .msgln div. It will contain the date and time generated by the date() function, the session of the user's name, and the text, which is also sorrounded by the htmlspecialchars() function to prevent from XSS.
Lastly, we close our file handle using fclose(). -->

<?php

session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];

    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}

?>
