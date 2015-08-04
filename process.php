<?php
include_once("config.php");
set_time_limit(24*60*60);
if($_POST)
{
	//Post variables we received from user
	$userGroups 	= $_POST["usergroups"];
	$userMessage 	= $_POST["message"];

	if(strlen($userMessage)<1) {
		//message is empty
		$userMessage = 'No message was entered!';
	}

	//posts link on group wall
	/*
	$msg_body = array(
		'link' => 'https://www.facebook.com/swiftintern',
		'message' => $userMessage,
	);
	$msg_body = array(
		'subject' => 'Subject of Note',
		'message' => 'message for my wall'
	);
	$msg_body = array(
		'question' => 'Do you like saaraan.com?', //Question
		'options' => array('Yes I do','No I do Not','Can not Say'), //Answers
		'allow_new_options' => 'true' //Allow other users to add more options
	);
	$msg_body = array(
		'source' => '@'.realpath('myphoto/somephot.gif'),
		'message' => 'message for my wall'
	);
	$msg_body = array(
		'source' => '@'.realpath('myphoto/somephot.gif'),
		'message' => 'message for my wall',
		'published' => 'false', //Keep photo unpublished
		'scheduled_publish_time' => '1333699439' //Or time when post should be published
	);
	*/
	
	//posts statuses message on group wall
	$photo = "C:/wamp/www/group-poster/logo.png";

	$msg_body = array(
		//'source' => class_exists('CurlFile', false) ? new CURLFile($photo, 'image/png') : "@{$photo}",
		'message' => $userMessage,
	);

	if ($fbuser) {
		foreach ($userGroups as $userGroupId) {
			//HTTP POST request to GROUP_ID/feed with the publish_stream
			if(isset($msg_body['source'])) {
				$post_url = '/'.$userGroupId.'/photos';
			} else{
				$post_url = '/'.$userGroupId.'/feed';
			}
			try {
				$postResult[] = $facebook->api($post_url, 'post', $msg_body );
			} catch (FacebookApiException $e) {
				echo $e->getMessage();
			}
		}
	}else{
		$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
		header('Location: ' . $loginUrl);
	}

	//Show sucess message
	if($postResult){
		echo '<html><head><title>Message Posted</title><link href="style.css" rel="stylesheet" type="text/css" /></head><body>';
		echo '<div id="fbgroupform" class="groupform" align="center">';
		echo '<h1>Your message is posted on your facebook group wall.</h1>';
		echo '<a class="button" href="'.$homeurl.'">Back to Main Page</a> <a target="_blank" class="button" href="http://www.facebook.com/groups/'.$userGroupId.'">Visit Your Group</a>';
		echo '</div>';
		echo '</body></html>';
	}
}
?>
