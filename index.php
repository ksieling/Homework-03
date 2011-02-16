<?php
/*
 * @author Kevin Sieling
 * @category ANM293 Advanced PHP
 * 
 * Project-03
 * 
 * Build an index.php page which includes Swift Mailer that sends an
 * e-mail from a google account
 * 
 */
try {
// sets the time zone to Eastern Standard
  date_default_timezone_set('America/Detroit');
  // @turns off errors
  // sets the display of errors to off in the local ini file
  @ini_set('display_errors','Off');
  // turns on error logging in the local ini file
  @ini_set('log_errors','On');
  // sets a maximum execution time of 300 seconds to prevent timeouts
  @ini_set('max_execution_time', 300);
  // sets error reporting specifics
  error_reporting(E_ALL & ~E_STRICT);

  // sets the slash type depending on environment
  if( PATH_SEPARATOR  == ';' )
    define('SLASH','\\');
  else
    define('SLASH','/'); 

  // sets the app path a constant
  define('APP_PATH', realpath(dirname(__FILE__)));
  
  // sets the include path, where to look for the include file
  set_include_path('.'.PATH_SEPARATOR.implode(PATH_SEPARATOR, array(
    realpath(APP_PATH . SLASH . 'library' . SLASH . 'lib')
  )));
  
  // forces the include of the swift_required.php file
  @(include_once('swift_required.php'));
  
  // builds a new instance of transport from the swift mailer library
  $transport = Swift_SmtpTransport::newInstance()
    ->setHost('smtp.gmail.com')
    ->setPort(465)
    ->setEncryption('ssl')
    ->setUsername('kevinsieling@gmail.com')
    ->setPassword('gmail454');
  
  // builds a new instance of mailer from the library using the transport
  $mailer = Swift_Mailer::newInstance($transport);
  
  // builds a new instance of a message
  $message = Swift_Message::newInstance()
    ->setSubject('Kevin Sieling, SWIFT Mailer 4.0.6')
    ->setFrom(array('kevinsieling@gmail.com' => 'Kevin Sieling'))
    ->setTo('k.sieling@hotmail.com')
    ->setBody('I rock at PHP', 'text/html');
  
  // sends the message
  $numSent = $mailer->send($message);
  
} catch(Exception $e) {

  trigger_error('Send message error',E_USER_NOTICE);
  
  }
    
 ?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Swift Mailer</title>
</head>
<body>


<?php
  // displays the contents of the message
  echo $message->toString();
  
  // displays Sent if the message was sent, Failed if it was not sent
  if ($mailer->send($message)) {
    echo "Sent";
  }
  else {
    echo "Failed";
  }
?>
  
  
</body>
</html>