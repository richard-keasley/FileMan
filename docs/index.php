<?php include __DIR__ . '/_head.php';?>
<h1>FileMan</h1>

<h2>installation</h2>
<p>Copy the entire folder. Make sure it sits within your Website root path.</p>
<p>Plug-ins can be included as <code>(command).js</code>. 
There may be other helper files associated with the plug-in. 
They should all be named <code>(command)*</code>. 
<strong>Example:</strong> <code>add_file.js</code>, <code>add_file.php</code> are used to run the command "add_file".</p>
<p>You need to create <a href="settings.php">fileman.settings.php</a> for your application.</p>

<h2>Dependencies</h2>
<dl>
<dt>PHP</dt>
<dd>Nothing extreme</dd>
<dt>jQuery<dt>
<dd>Including the UI style sheet. No ui components are used directly by FileMan. The Plupload queue widget relies on jQuery and jQuery-ui.</dd> 
<dt>plupload<dt>
<dd><a href="https://www.plupload.com/">Plupload (Queue widget)</a> is used as (<code>add_file</code>). It can be replaced if you want.</dd>
<dt>icomoon font</dt>
<dd><a href="https://icomoon.io/">IcoMoon font</a> is used to create icons. <a href="../icomoon/">View the icon set</a>.</dd>
</dl>

<h2>Implementation</h2>
<ul>
<li>Include the main <code>include.php</code></li>
<li>Put the containing elements in</li>
<li>Use jQuery to initialize the FileMan</li>
</ul>
<p>Plug-ins appear as buttons in the button bar. Note plug-in elements are not loaded until the corresponding button is clicked.</p>
<p>The file manager is set up with the "init" method: <code>FileMan.init(selector=0, fm_path='', filter='')</code>. Leave all values blank for the default popup to be created.</p>
<dl>
<dt>selector (string)</dt>
<dd>String to describe element. This will be used as a jQuery object <code>$(selector)</code>. Leave it blank for default pop-up dialog.</dd>
<dt>fm_path (string)</dt>
<dd>The start path for FileMan. Note: This path is relative to <code>fm_root</code> in settings. Leave it blank for <code>fm_root</code>.</dt>
<dt>filter (string)</dt>
<dd>The filter to use for FileMan (including uploads). NB: This should be one of the <code>upload_types</code> in settings. Leave it blank to show all files. Note: Even if there is no filter, you can only upload file types registered in <code>upload_types</code>.</dd>
</dl>  

<h2>Examples</h2>
<ul>
<li><a href="simple.php">Simple</a></li>
<li><a href="popup1.php">Dialog</a></li>
<li><a href="popup2.php">Dialog with start path and filter</a></li>
<li><a href="tiny.php">TinyMCE integration for images</a></li>
</ul>

<?php include __DIR__ . '/_foot.php';
