<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="File Manager">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Richard Keasley">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="all">
<link href="/INC/icofont/style.css" rel="stylesheet" type="text/css" media="all">
<title>File Manager - simple</title>
</head>
<body>
<h1>File Manager</h1>
<p><a href=".">back</a></p>
<h2>Simple</h2>

<?php include_once dirname(__DIR__) . '/include.php';?>
<div id="fileman">File manager unavailable</div> 
<script>
$(function() {
	var fileman_element = FileMan.init('#fileman');
});
</script>

<p><a href=".">back</a></p>
</body>
</html>
