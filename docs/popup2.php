<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="FileMan">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Richard Keasley">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="all">
<link href="../icomoon/style.css" rel="stylesheet" type="text/css" media="all">
<title>FileMan - popup 2</title>
</head>
<body>
<h1>FileMan - popup 2</h1>
<p class="nav"><a class="icon-undo" href=".">back</a></p>
<h2>Dialog with start folder and filter</h2>

<?php include_once dirname(__DIR__) . '/include.php';?>
<button name="popup">Fileman</button>
<p>Here is the value: <span id="get_file"></span></p>
<script>
$(function() {
	var $btn = $('button[name=popup]').button();
	$btn.click(function(){ 
		var fileman_dialog = FileMan.init(0, '/test/test.jpg', 'image');
		FileMan.get_file = function(listitem) {
			$('#get_file').html(FileMan.item.html(listitem));
			fileman_dialog.dialog('close');
		};
		fileman_dialog.dialog('open'); 
	});
});
</script>

<pre>
&lt;?php include_once '{path-to-fileman}/include.php';?&gt;
&lt;button name="popup"&gt;Fileman&lt;/button&gt;
&lt;p&gt;Here is the value: &lt;span id="get_file"&gt;&lt;/span&gt;&lt;/p&gt;
&lt;script&gt;
$(function() {
	var $btn = $('button[name=popup]').button();
	$btn.click(function(){ 
		var fileman_dialog = FileMan.init(0, '/test/test.jpg', 'image');
		FileMan.get_file = function(listitem) {
			$('#get_file').html(FileMan.item.html(listitem));
			fileman_dialog.dialog('close');
		};
		fileman_dialog.dialog('open'); 
	});
});
&lt;/script&gt;
</pre>

<p class="nav"><a class="icon-undo" href=".">back</a></p>
<script>
$(function() {
	$('.nav .icon-undo').button();
}
</script>
</body>
</html>
