<?php include __DIR__ . '/_head.php';?>

<h1>FileMan - TinyMCE</h1>
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

<?php include __DIR__ . '/_foot.php';
