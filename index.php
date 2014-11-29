<?php
include_once("config.php");
set_time_limit(24*60*60);
if ($fbuser) {
  try {
	 	$user_profile = $facebook->api('/me');
		//List user groups details using Facebook Query Language (FQL)
		$fql_query = 'select gid, name from group where gid IN (SELECT gid FROM group_member WHERE uid='.$fbuser.')';
		
		//FQL query to list only groups where user is administrator.(administrator='true')
		//$fql_query = 'select gid, name from group where gid IN (SELECT gid FROM group_member WHERE uid='.$fbuser.' AND administrator=\'true\')';
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
		if user is logged in but FQL is not returning any groups, we need to make sure user does have a group
		OR "user_groups" permissions isn't granted yet by the user. 
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
<title>Post to user Group Wall</title>
</head>
<body>

<div class="fbgroupwrapper">
<div id="fbgroupform" class="groupform">
<form id="form" name="form" method="post" action="process.php">
<h1>Post to Multiple Facebook Group Wall</h1>
<p>Choose a group to post. <?php
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
<label>Groups<span class="small">Select Groups</span></label><br>
<label><b><u><a onclick="myFunction()">Select All</a></u></b></label><br>
<ol>
<?php
    foreach ($postResults as $postResult) {
    	echo '<li>'.$postResult["name"].'<input type="checkbox" name="usergroups[]" id="ugroups" value="'.$postResult["gid"].'"></li>';
    }
?>
</ol>
<br><br>
<label>Message<span class="small">Write something to post!</span></label><br>
<textarea name="message"></textarea><br>
<button type="submit" class="button" id="submit_button">Post Message</button>
<div class="spacer"></div>
</form>
</div>
</div>
<script>
var myFunction = function (argument) {
	var inputs = document.getElementsByTagName("input");
	var checkboxes=[];
	for(var i = 0; i < inputs.length; i++) {
		if(inputs[i].type == "checkbox") {
			//checkboxes.push( inputs[i] ); 
			inputs[i].checked = true;
		}
	}
}
</script>
</body>
</html>
<?php
}
?>

</body>
</html>
