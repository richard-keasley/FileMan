<?php 
/* user settings */
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
/* end user settings */

class fm_settings {
const json_flags = JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR;
static $url_root = '';  // website root path
static $fm_root = DOCROOT . "/files"; // base path for FileMan
static $upload_types = array(); // file types
static $perms = array();

static function url() {
	return self::path(__DIR__, 'file', 'url');
}

static function path($path, $from='fm', $to='file') {
	switch($from) { // get file path
		case 'url': 
			$filepath = self::$url_root . $path;
			break;
		case 'file':
			$filepath = $path;
			break;
		case 'fm' : 
		default:
			$filepath = self::$fm_root . DIRECTORY_SEPARATOR . $path ;
	}
	// return appropriate root if filepath is invalid
	$filepath = realpath($filepath);
	if(!$filepath) return ''; 
	switch($to) {
		case 'url': $root = self::$url_root; break;
		case 'fm': $root = self::$fm_root; break;
		case 'file':
		default:
			$root = '';
	}
	if($root) return strpos($filepath, $root)===0 ? substr($filepath, strlen($root)) : '' ;
	else return $filepath;
}

static function perms($perm_name) {
	return in_array('get_dir', self::$perms) ? in_array($perm_name, self::$perms) : false;
}
	
} // class fm_settings
// Allow those who can get_file to preview_file
if(in_array('get_file', fm_settings::$perms)) fm_settings::$perms[] = 'preview_file';
