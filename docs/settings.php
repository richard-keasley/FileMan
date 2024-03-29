<?php include __DIR__ . '/_head.php';?>

<h1>FileMan - settings</h1>

<p>FileMan will attempt to load <code>../fileman.settings.php</code>. You can create the settings file from the template <code>fileman.settings.php</code>. Save this in the <strong>parent folder</strong> of FileMan. If no settings file is found, FileMan will return the following message:</p> 
<div class="ui-state-error icon-error">No access to FileMan</div>

<h3>Settings</h3>
<dl>
<dt>Permissions</dt>
<dd>Nothing will work until permissions have been set. Permissions are held in the static array <code>perms</code> in <code>settings.php</code>.</dd>
<dd><strong>Example:</strong> Permission to get a directory is granted as follows: <code>fm_settings::$perms[] = 'get_dir';</code></dd>
<dd><strong>NB:</strong> You can't do anything if you don't have permission "get_dir". Make sure it's the first permission set.</dd>
<dd>There are three verbs: "get", "add", "del". These three verbs act on the following objects: "file", "dir", "settings". A command comprises (verb)_(object). E.g. <code>get_dir, del_dir, get_settings</code>.</dd>
<dd>Possible permissions are: get_dir, get_file, add_dir, add_file, del_dir, del_file, get_settings.</dd>

<dt>url_root</dt>
<dd>Website root path. Used to calculate HTML for file items (e.g. get_file).</dd>
<dd><strong>NB:</strong> If file is outside of <code>url_root</code> HTML values will be returned empty.</dd>

<dt>fm_root</dt>
<dd>base path for FileMan. The FileMan can not work outside of this path.</dd>
<dd><strong>NB:</strong> If <code>fm_root</code> is outside of <code>url_root</code> HTML values will be returned empty.</dd>

<dt>upload_types</dt> 
<dd>Use <code>type=>extensions</code>.</dd>
<dd><strong>Example:</strong> <code>'image' => 'jpg,gif,png'</code>. Only files with the given extensions can be uploaded. A filter can be set to make FileMan show only files of the filtered type (or allow uplaods).</dd>
<dd><strong>File icons</strong> are set according to <code>upload_type filter</code>.</dd>
</dl>

<p>An example <code>../fileman.settings.php</code>:</p>
<pre>
&lt;?php
require_once {all the files your site needs};
/* permissions */
if('user has permission to read files') {
	fm_settings::$perms[] = 'get_dir';
	fm_settings::$perms[] = 'get_file';
}
if('user has permission to edit files') {
	fm_settings::$perms[] = 'add_file';
	fm_settings::$perms[] = 'del_file';
}
if('user is a site admin') {
	fm_settings::$perms[] = 'add_dir';
	fm_settings::$perms[] = 'del_dir';
	fm_settings::$perms[] = 'get_settings';
}
// website root path
fm_settings::$url_root = $_SERVER['DOCUMENT_ROOT']; 
// base path for FileMan
fm_settings::$fm_root  = {path to your files}; 
// upload_types [label] = extensions
fm_settings::$upload_types['image'] = 'jpg,gif,png';
fm_settings::$upload_types['pdf'] = 'pdf';
</pre>

<?php include __DIR__ . '/_foot.php';
