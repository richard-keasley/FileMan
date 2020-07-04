<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="FileMan File Manager">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Richard Keasley">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="all">
<link href="../icomoon/style.css" rel="stylesheet" type="text/css" media="all">
<title>FileMan - simple</title>
</head>
<body>
<h1>FileMan - simple</h1>
<p><a href=".">back</a></p>
<h2>Simple element on the page.</h2>

<?php include_once dirname(__DIR__) . '/include.php';?>
<div id="fileman">File manager unavailable</div> 
<script>
$(function() {
	var fileman_element = FileMan.init('#fileman');
});
</script>

<pre>
&lt;?php include_once '{path-to-fileman}/include.php';?&gt;
&lt;div id="fileman"&gt;File manager unavailable&lt;/div&gt; 
&lt;script&gt;
$(function() {
	var fileman_element = FileMan.init('#fileman');
});
&lt;/script&gt;
</pre>

<p><a href=".">back</a></p>
</body>
</html>
