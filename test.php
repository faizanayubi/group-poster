<?php
	if (isset($_POST['submit'])) {
		//echo "<pre>", print_r($_POST['food']), "</pre>";
		$foods = $_POST['food'];
		foreach ($foods as $food) {
			echo $food."<br>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>form</title>
</head>
<body>
<form method="post" action="test.php">
	<input type="checkbox" name="food[]" value="Pizza">Pizza<br>
	<input type="checkbox" name="food[]" value="Biryani">Biryani<br>
	<input type="checkbox" name="food[]" value="Chowmeen">Chowmeen<br>
	<input type="submit" name="submit">
</form>
</body>
</html>