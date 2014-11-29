<?php
include_once("config.php");

if($_POST)
{
	//Post variables we received from user
	$userPageId 	= $_POST["userpages"];
	$userMessage 	= $_POST["message"];
	
	if(strlen($userMessage)<1) 
	{
		//message is empty
		$userMessage = 'No message was entered!';
	}
	
		//HTTP POST request to PAGE_ID/feed with the publish_stream
		$post_url = '/'.$userPageId.'/feed';

		/*
		// posts message on page feed
		$msg_body = array(
			'message' => $userMessage,
			'name' => 'Message Posted from Saaraan.com!',
			'caption' => "Nice stuff",
			'link' => 'http://www.saaraan.com/assets/ajax-post-on-page-wall',
			'description' => 'Demo php script posting message on this facebook page.',
			'picture' => 'http://www.saaraan.com/templates/saaraan/images/logo.png'
			'actions' => array(
								array(
									'name' => 'Saaraan',
									'link' => 'http://www.saaraan.com'
								)
							)
		);
		*/
	
		//posts message on page statues 
		$msg_body = array(
		'message' => $userMessage,
		);
	
	if ($fbuser) {
	  try {
			$postResult = $facebook->api($post_url, 'post', $msg_body );
		} catch (FacebookApiException $e) {
		echo $e->getMessage();
	  }
	}else{
	 $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
	 header('Location: ' . $loginUrl);
	}
	
	//Show sucess message
	if($postResult)
	 {
		 echo '<html><head><title>Message Posted</title><link href="style.css" rel="stylesheet" type="text/css" /></head><body>';
		 echo '<div id="fbpageform" class="pageform" align="center">';
		 echo '<h1>Your message is posted on your facebook wall.</h1>';
		 echo '<a class="button" href="'.$homeurl.'">Back to Main Page</a> <a target="_blank" class="button" href="http://www.facebook.com/'.$userPageId.'">Visit Your Page</a>';
		 echo '</div>';
		 echo '</body></html>';
	 }
}
 
?>
