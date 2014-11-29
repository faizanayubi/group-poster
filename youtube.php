<?php
/*	$channel = 'https://gdata.youtube.com/feeds/api/videos?q=swiftintern&max-results=5&v=2&alt=jsonc&orderby=published';
	$playlist = 'http://gdata.youtube.com/feeds/api/playlists/$playlist?v=2&alt=jsonc&max-results=50';

	$json = file_get_contents($channel);
	$obj = json_decode($json);
	
	//$content = file_get_contents($obj->data->thumbnail->hqDefault);

	echo "<pre>", print_r($obj),"</pre>";
*/

$json_output = file_get_contents("http://gdata.youtube.com/feeds/api/videos/wGG543FeHOE?v=2&alt=json");
$json = json_decode($json_output, true);

//This gives you the video description
$video_description = $json['entry']['media$group']['media$description']['$t'];

//This gives you the video views count
echo $view_count = $json['entry']['yt$statistics']['viewCount'];

//This gives you the video title
$video_title = $json['entry']['title']['$t'];

//echo "<pre>", print_r($json),"</pre>";

?>