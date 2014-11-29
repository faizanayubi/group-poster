<?php
include_once("config.php");
if ($fbuser) {
  try {
	 	$user_profile = $facebook->api('/me');
		//Get user pages details using Facebook Query Language (FQL)
		$fql_query = 'SELECT page_id, name, page_url FROM page WHERE page_id IN (SELECT page_id FROM page_admin WHERE uid='.$fbuser.')';
		$postResults = $facebook->api(array( 'method' => 'fql.query', 'query' => $fql_query ));
	} catch (FacebookApiException $e) {
		echo $e->getMessage();
		$fbuser = null;
  }
}else{
		//Show login button for guest users
		$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
		echo '<a href="'.$loginUrl.'"><img src="images/facebook-login.png" border="0"></a>';
		$fbuser = null;
}

if($fbuser && empty($postResults))
{
		/*
		if user is logged in but FQL is not returning any pages, we need to make sure user does have a page
		OR "manage_pages" permissions isn't granted yet by the user. 
		Let's give user an option to grant application permission again.
		*/
		$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
		echo '<br />Could not get your page details!';
		echo '<br /><a href="'.$loginUrl.'">Click here to try again!</a>'; 
		
}elseif($fbuser && !empty($postResults)){

//Everything looks good, show message form.
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Post to user Page Wall</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="fbpagewrapper">
<div id="fbpageform" class="pageform">
<form id="form" name="form" method="post" action="process.php">
<h1>Post to Facebook Page Wall</h1>
<p>Choose a page to post. <?php
/*
Get Log out URL
Due to some bug or whatever, SDK still thinks user is logged in even
after user logs out. To deal with it, user is redirected to another page "logged-out.php" after logout
it is working fine for me with this trick. Hope it works for you too.
*/
$logOutUrl = $facebook->getLogoutUrl(array('next'=>$homeurl.'logged-out.php'));
echo '<a href="'.$logOutUrl.'">Log Out</a>';
?>
</p>
<label>Pages
<span class="small">Select a Page</span>
</label>
<select name="userpages" id="upages">
	<?php
    foreach ($postResults as $postResult) {
            echo '<option value="'.$postResult["page_id"].'">'.$postResult["name"].'</option>';
        }
    ?>
</select>
<label>Message
<span class="small">Write something to post!</span>
</label>
<textarea name="message"></textarea>
<button type="submit" class="button" id="submit_button">Send Message</button>
<div class="spacer"></div>
</form>
</div>
</div>
</body>
</html>
<?php
}
?>

</body>
</html>
