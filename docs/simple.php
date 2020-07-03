<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="File Manager">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Richard Keasley">
<script src="/INC/jquery/jquery.min.js"></script>
<script src="/INC/jquery/jquery-ui.min.js"></script>
<link href="/INC/jquery/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all">
<link href="/INC/icofont/style.css" rel="stylesheet" type="text/css" media="all">

<title>File Manager - simple</title>
</head>
<body>
<h1>File Manager</h1>
<p><a href=".">back</a></p>
<h2>Simple</h2>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/INC/fileman/include.php';?>
<div id="fileman"></div> 
<script>
$(function() {
	var fileman_element = FileMan.init('#fileman');
});
</script>

<p><a href=".">back</a></p>
</body>
</html>
