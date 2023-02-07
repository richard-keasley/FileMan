<?php include __DIR__ . '/_head.php';?>

<h1>FileMan - simple</h1>
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

<?php include __DIR__ . '/_foot.php';
