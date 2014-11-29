<?php

  // This code example uses the PHP Media API wrapper
  // For the PHP Media API wrapper, visit http://docs.brightcove.com/en/video-cloud/open-source/index.html

  // Include the BCMAPI Wrapper
  require('bc-mapi.php');
        
  // Instantiate the class, passing it our Brightcove API tokens (read, then write)
  $bc = new BCMAPI(
    '[[READ_TOKEN]]',
    '[[WRITE_TOKEN]]'
  );

  // Create an array of meta data from our form fields
  $metaData = array(
    'name' => $_POST['bcVideoName'],
    'shortDescription' => $_POST['bcShortDescription']
  );
  
  // Move the file out of 'tmp', or rename
  rename($_FILES['videoFile']['tmp_name'], '/tmp/' . $_FILES['videoFile']['name']);
  $file = '/tmp/' . $_FILES['videoFile']['name'];
  
  // Create a try/catch
  try {
    // Upload the video and save the video ID
    $id = $bc->createMedia('video', $file, $metaData);
          echo 'New video id: ';
          echo $id;
  } catch(Exception $error) {
    // Handle our error
    echo $error;
    die();
  }
?>