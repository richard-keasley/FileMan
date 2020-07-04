<?php 
/* user settings 
Do what you liek inthis file to setup permissions / etc. 
This is loaded early, no JS in here. 
*/

require_once "$_SERVER[DOCUMENT_ROOT]/common.php";
/* permissions */
if(HattSite::$siteACL->hasPermission('inventory_view')) {
	fm_settings::$perms[] = 'get_dir';
	fm_settings::$perms[] = 'get_file';
}
if(HattSite::$siteACL->hasPermission('inventory_edit')) {
	fm_settings::$perms[] = 'add_file';
	fm_settings::$perms[] = 'del_file';
}
if(HattSite::$siteACL->hasPermission('site_admin')) {
	fm_settings::$perms[] = 'add_dir';
	fm_settings::$perms[] = 'del_dir';
	fm_settings::$perms[] = 'get_settings';
}
// website root path
fm_settings::$url_root = DOCROOT; 
// base path for FileMan
fm_settings::$fm_root  = DOCROOT . "/files"; 
// file types [label] = extensions
fm_settings::$upload_types['image'] = 'jpg,gif,png';
fm_settings::$upload_types['pdf'] = 'pdf';

echo '######';
