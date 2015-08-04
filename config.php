<?php
include_once("inc/facebook.php"); //include facebook SDK
 
######### edit details ##########
$appId = '726203200751397'; //Facebook App ID
$appSecret = '04b5fe01783aaa233500dc6369da7b3c'; // Facebook App Secret
$return_url = 'http://localhost/group-poster/process.php';  //return url (url to script)
$homeurl = 'http://localhost/group-poster/';  //return to home
$fbPermissions = 'user_groups, publish_actions';  //Required facebook permissions
##################################

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret,
  'fileUpload' => true
));

$fbuser = $facebook->getUser();
?>