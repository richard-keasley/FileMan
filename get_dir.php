<?php
require_once __DIR__ . '/settings.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: application/json; charset=UTF-8");

set_error_handler('get_dir_die');
ob_start();

fm_get_dir::check_access('get_dir');

$method = strval(key($_GET));
if(!strlen($method)) trigger_error("No method supplied");
$response = fm_get_dir::process($method, $_GET[$method]);
if(is_dir(fm_get_dir::$filepath)) fm_get_dir::$dir = fm_get_dir::$filepath ;
$fm_path = fm_settings::path(fm_get_dir::$dir, 'file', 'fm');
$filter = filter_input(INPUT_GET, 'filter');

#var_dump(fm_get_dir::$dir);
#var_dump(fm_get_dir::$filepath);
#var_dump($filter);
#var_dump($fm_path);

if($filter) echo "<p>Filtering for: $filter.</p>";
?>
<ul class="path">
<?php 
$filepath = fm_settings::path('/', 'fm', 'file');
echo fm_get_dir::listitem($filepath);
$items = explode(DIRECTORY_SEPARATOR, $fm_path);
foreach($items as $item) {
	if($item) {
		$filepath .= DIRECTORY_SEPARATOR . $item;
		echo fm_get_dir::listitem($filepath);
	}
} ?>
</ul>

<ul class="files"><?php 
if($fm_path) echo fm_get_dir::listitem(fm_get_dir::$dir . DIRECTORY_SEPARATOR . '..', 1);
$list = glob(fm_get_dir::$dir . DIRECTORY_SEPARATOR . '*');
$sort = array();
foreach($list as $filepath) {
	$itemsort = 'z';
	if(is_dir($filepath)) $itemsort = 'a';
	if(is_link($filepath)) $itemsort = 'b';
	if(is_file($filepath)) $itemsort = 'c';
	$sort[] = $itemsort . basename($filepath);
}
array_multisort($sort, $list);
foreach($list as $filepath) echo fm_get_dir::listitem($filepath, 1, $filter);
?>
</ul><?php 
get_dir_die(0, $response);

class fm_get_dir {
static $method = '';
static $dir = '';
static $filepath = '';

static function process($method, $param) {
	fm_get_dir::check_access('get_dir');
	self::$method = $method;
	$filename = basename($param);
	#trigger_error($param);
	self::$dir = fm_settings::path(dirname($param), 'fm', 'file');
	self::$filepath = self::$dir . DIRECTORY_SEPARATOR . $filename;
	if(!in_array($method, get_class_methods('fm_get_dir'))) trigger_error("Invalid method");
	if(!self::$dir) trigger_error("Invalid path: " . self::$dir);
	return self::$method();
}

static function check_access($function) {
	if(!fm_settings::perms($function)) trigger_error("Permission denied");
}

static function get_settings() {
	self::check_access(__FUNCTION__);
	$list = array(
		'web_root' => fm_settings::url_root,
		'file_manager_root' => fm_settings::fm_root,
		'file_manager_url' => fm_settings::url(),
		'upload_types' => fm_settings::upload_types,
		'perms' => implode(', ', fm_settings::$perms)
	);
	
	echo '<ul>';
	foreach($list as $key=>$item) {
		echo "<li><strong>$key:</strong> ";
		if(is_array($item)) {
			echo '<ul>';
			foreach($item as $subkey=>$subitem) echo "<li><strong>$subkey:</strong> $subitem</li>";
			echo '</ul>';
		}
		else echo $item;
		echo "</li>";
	}
	echo '</ul>';
echo <<<EOT
<hr>
<p>Modify settings in <code>$list[file_manager_url]/settings.php</code>.</p>
<p><a href="$list[file_manager_url]/docs/" target="docs">Read how to setup</a></p>
EOT;
	
	get_dir_die(0, 'done');
}

static function get_dir() {
	self::check_access(__FUNCTION__);
	return fm_settings::path(self::$filepath, 'file', 'fm');
}

static function add_dir() {
	self::check_access(__FUNCTION__);
	$basename = basename(self::$filepath);
	if(file_exists(self::$filepath)) trigger_error("$basename already exists");
	if(!mkdir(self::$filepath)) trigger_error("Could not create $basename");
	return "$basename created";
}

static function del_dir() {
	self::check_access(__FUNCTION__);
	$basename = basename(self::$filepath);
	if(!is_dir(self::$filepath)) trigger_error("$basename not found");
	if(count(scandir(self::$filepath)) > 2) trigger_error("$basename is not empty");
	if(!rmdir(self::$filepath)) trigger_error("Could not delete $basename");
	return "$basename deleted";
}

static function del_file() {
	self::check_access(__FUNCTION__);
	$basename = basename(self::$filepath);
	if(!is_file(self::$filepath)) trigger_error("$basename not found");
	if(!unlink(self::$filepath)) trigger_error("Could not delete $basename"); ;
	return "$basename deleted";
}

static function listitem($filepath, $icons=0, $filter=0) {
	self::check_access('get_dir');
	$basename = $filepath==fm_settings::fm_root ? '[root]' : basename($filepath); 
	$filepath = realpath($filepath);
	if(!$filepath) return '';

	$li = array(
		'class' => 'unknown',
		'title' => fm_settings::path($filepath, 'file', 'fm')
	);
	if(is_dir($filepath)) $li['class'] = 'dir';
	if(is_file($filepath)) $li['class'] = 'file';
	if(is_link($filepath)) $li['class'] = 'link';
	$url = fm_settings::path($filepath, 'file', 'url');
	if($url) $li['data-url'] = $url;
	
	$procicons = '';
	if(!$basename) $basename = '[root]';
	if($icons) {
		if($basename!=='..') { // process icons
			if(in_array("preview_$li[class]", fm_settings::$perms)) $procicons .= '<span class="process" data-method="preview" title="Preview"></span>';
			if(in_array("del_$li[class]", fm_settings::$perms)) $procicons .= '<span class="process" data-method="del" title="Delete"></span>';
			if($procicons) $procicons = '<span class="procicons">' . $procicons . '</span>';
		}  
		switch($li['class']) { // item type
			case 'file' : 
				$mime = explode('/', mime_content_type($filepath));
				if(count($mime)>1) {
					$li['data-type'] = $mime[0]=='application' ? $mime[1]: $mime[0] ;
				}
				else $li['data-type'] = 'unknown';
				
				if($filter && $li['data-type']!=$filter) return '';
				break;
			case 'dir': 
				$li['data-type'] = $basename==='..' ? 'parent' : 'dir'; 
				break;
			default: 
				$li['data-type'] = $li['class'];
		}
	}
	$class = $filepath==self::$filepath ? 'selected process' : 'process' ;
	$item = "<span class=\"$class\" data-method=\"get\">$basename</span>";

	$li_attr = array(); 
	foreach($li as $key=>$val) $li_attr[] = "$key=\"$val\"";

	return sprintf('<li %s>%s%s</li>', 
		implode(' ', $li_attr), 
		$procicons,
		$item
	);
}

} // class fm_get_dir

function get_dir_die($err_num, $msg='') {
	$json = array(
		'status' => $err_num ? 'error' : 'ok',
		'err_num' => $err_num,
		'msg' => $msg,
		'dir' => fm_settings::path(fm_get_dir::$dir, 'file', 'fm') . DIRECTORY_SEPARATOR,
		'htm' => ob_get_clean()
	);
	echo json_encode($json, fm_settings::json_flags);
	die;
}

