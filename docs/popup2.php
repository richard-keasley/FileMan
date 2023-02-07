<?php include __DIR__ . '/_head.php';?>

<title>FileMan - popup 2</title>
</head>
<body>
<h1>FileMan - popup 2</h1>
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
<?php include __DIR__ . '/_foot.php';
