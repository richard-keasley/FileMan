<?php 
// user settings 
$include = dirname(__DIR__) . '/fileman.settings.php';
if(file_exists($include)) include $include;

// Allow those who can get_file to preview_file
if(in_array('get_file', fm_settings::$perms)) fm_settings::$perms[] = 'preview_file';

class fm_settings {
const json_flags = JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR;
const version = '1.1.0';
const released = '2023-02-07';

static $url_root = '';  // website root path
static $fm_root = ''; // base path for FileMan
static $upload_types = array(); // file types
static $max_file_size = 0; // only for upload 

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
