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
<title>FileMan - TinyMCE</title>
</head>
<body>
<h1>FileMan - TinyMCE</h1>
<p class="nav"><a class="icon-undo" href=".">back</a></p>
<h2>TinyMCE integration for inserting images / downloads into HTML</h2>

<textarea class="html"></textarea>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.4.0/tinymce.min.js"></script>
<?php include_once dirname(__DIR__) . '/include.php';?>
<script>
$(function() {
	tinymce.init({
		selector:'textarea[class=html]',
		toolbar: "undo redo | link image FileMan",
		setup: function(editor) { 
			editor.ui.registry.addButton('FileMan', {
				text: 'FileMan', // the text to display alongside the button
				icon: 'image', // the icon to display alongside the button
				onAction: function(_) {
					var fileman_element = FileMan.init();
					FileMan.get_file = function(listitem) {
						editor.insertContent(FileMan.item.html(listitem));
						fileman_element.dialog('close');
					};
					fileman_element.dialog('open');
				}
			})
		}
	})
});
</script>

<pre>
&lt;textarea class="html"&gt;&lt;/textarea&gt;
&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.4.0/tinymce.min.js"&gt;&lt;/script&gt;
&lt;?php include_once dirname(__DIR__) . '/include.php';?&gt;
&lt;script&gt;
$(function() {
	tinymce.init({
		selector:'textarea[class=html]',
		toolbar: "undo redo | link image FileMan",
		setup: function(editor) { 
			editor.ui.registry.addButton('FileMan', {
				text: 'FileMan', // the text to display alongside the button
				icon: 'image', // the icon to display alongside the button
				onAction: function(_) {
					var fileman_element = FileMan.init();
					FileMan.get_file = function(listitem) {
						editor.insertContent(FileMan.item.html(listitem));
						fileman_element.dialog('close');
					};
					fileman_element.dialog('open');
				}
			})
		}
	})
});
&lt;/script&gt;
</pre>

<p class="nav"><a class="icon-undo" href=".">back</a></p>
<script>
$(function() {
	$('.nav .icon-undo').button();
});
</script>
</body>
</html>
