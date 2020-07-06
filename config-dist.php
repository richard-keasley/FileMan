<?php
/* Template for config.php */
// Read documentation on config.php
// Edit this file and save as "config.php"

/* add any site requirements here */
# require_once '{all the files your site needs}';

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

// website root path for generating HTML links
fm_settings::$url_root = $_SERVER['DOCUMENT_ROOT']; 

// base path for FileMan browsing
fm_settings::$fm_root  = {path to your files}; 

// upload_types [label] = extensions
fm_settings::$upload_types['image'] = 'jpg,gif,png';
fm_settings::$upload_types['pdf'] = 'pdf';
