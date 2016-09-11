<?php

require_once("phpMailer/class.phpmailer.php");
require_once("phpMailer/class.smtp.php");
require_once("phpMailer/language/phpmailer.lang-he.php");
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8'); 

if(!isset($_POST['submit'])) {
	
    //This page should not be accessed directly. Need to submit the form.
	echo "שגיאה, יש לשלוח טופס.";
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$q1 = $_POST['tax1'];
$q2 = $_POST['tax2'];
$q3 = $_POST['tax3'];
$q4 = $_POST['tax4'];
$q5 = $_POST['tax5'];
$q6 = $_POST['tax6'];
$q7 = $_POST['tax7'];

//Validate first


if(IsInjected($email))
{
    echo "ערך לא תקין בשדה \" מייל\"";
    exit;
}


$to_name = "TaxIL";
$to = "tomyd71@gmail.com";

$subject = "TaxIL | התקבלה פניה חדשה";
$message =  "קיבלת מבדק החזר מס חדש מ$name:\n\n". "טלפון: $phone\n". "מייל: $email\n\n" . "טופס:\n\n
האם אתה או בת זוגתך שילמתם מס הכנסה בין השנים 2009-2015? $q1\n
האם אתה או בת זוגתך החלפתם מקום עבודה בין השנים 2009-2015? $q2\n
האם אתה או בת זוגתך קיבלתם גימלה מביטוח לאומי (כגון דמי לידה, דמי פגיעה) בין השנים 2009-2015? $q3\n
האם נולד לך ילד בין השנים 2009-2015? $q4\n
האם סיימת תואר אקדמי או לימודי תעודה בין נשנים 2007-2015 $q5\n
האם השתחררת משירות צבאי בין השנים 2007-2015? $q6\n
האם הייתה לך פעילות בשוק ההון בין השנים 2009-2015? $q7\n";

$message = wordwrap($message,70);
$from_name = "TaxIL";
$from = "noreply@taxil.com";

//PHP mail version (default):
$mail = new PHPMailer();

$mail->FromName = $from_name;
$mail->From = $from;
$mail->AddAddress($to, $to_name);
$mail->Subject = mb_encode_mimeheader($subject, "UTF-8");
$mail->Body = $message;

$result = $mail->Send();
echo $result ? $success : 'Error';


//done. redirect to thank-you page.
$success = header('Location: thank-you.html');

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>