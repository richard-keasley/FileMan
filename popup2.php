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
<h2>Dialog with start folder and filter</h2>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/INC/fileman/include.php';?>
<button name="popup">Fileman</button>
<p>Here is the value: <span id="get_file"></span></p>
<script>
$(function() {
	$('button[name=popup]').click(function(){ 
		var fileman_dialog = FileMan.init(0, '/test/test.jpg', 'image');
		FileMan.get_file = function(listitem) {
			$('#get_file').html(FileMan.item.html(listitem));
			fileman_dialog.dialog('close');
		};
		fileman_dialog.dialog('open'); 
	});
});
</script>

<p><a href=".">back</a></p>
</body>
</html>