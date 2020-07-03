<?php
require_once __DIR__ . "/settings.php";
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: application/json; charset=UTF-8");

set_error_handler('add_file_die');

if(!fm_settings::perms('add_file')) add_file_die(100, 'Permission denied');

// Settings
set_time_limit(60); // max execution time [sec]
$cleanupdestpath = true; // Remove old files
$maxFileAge = 20 * 60; // Temp file age [sec]

// destination path
$destpath = empty($_REQUEST['destpath']) ? '' : $_REQUEST['destpath'];
$destpath = fm_settings::path($destpath, 'fm', 'file');
if(!$destpath) add_file_die(102, 'Destination path does not exist');
if(!is_dir($destpath)) add_file_die(102, 'Destination path does not exist');
$destpath .= '/';
#add_file_die(100, "destpath: $destpath");

// Get the file name
if(isset($_REQUEST["name"])) $fileName = $_REQUEST["name"];
elseif(!empty($_FILES)) $fileName = $_FILES["file"]["name"];
else $fileName = uniqid("file_");
$filePath = $destpath . $fileName;
#add_file_die(100, $filePath);

// check for overwrite
if(file_exists($filePath) && !fm_settings::perms('del_file')) add_file_die(100, "Can't overwrite $fileName");

// check file extension
$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
$ok = 0;
foreach(fm_settings::upload_types as $type=>$exts) {
	$exts = explode(',', $exts);
	if(in_array($file_ext, $exts)) $ok = 1;
}
if(!$ok) add_file_die(100, "$fileName has an invalid extension");

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

#add_file_die(100, print_r($_REQUEST, 1));

// Remove old temp files	
if($cleanupdestpath) {
	if(!$dir = opendir($destpath)) add_file_die(100, "Failed to open temp directory.");
	while(($file = readdir($dir)) !== false) {
		$tmpfilePath = $destpath . DIRECTORY_SEPARATOR . $file;
		// If temp file is current file proceed to the next
		if($tmpfilePath == "{$filePath}.part") continue;
		// Remove temp file if it is older than the max age and is not the current file
		if(preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) unlink($tmpfilePath);
	}
	closedir($dir);
}	

// Open temp file
if(!$out = fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	add_file_die(102, "Failed to open output stream.");
}

if(!empty($_FILES)) {
	if($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		add_file_die(103, "Failed to move uploaded file.");
	}
	// Read binary input stream and append it to temp file
	if(!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		add_file_die(101, "Failed to open input stream.");
	}
} 
else {	
	if(!$in = @fopen("php://input", "rb")) {
		add_file_die(101, "Failed to open input stream.");
	}
}

while($buff = fread($in, 4096)) fwrite($out, $buff);

fclose($out);
fclose($in);

// Check if file has been uploaded
if(!$chunks || $chunk==$chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);
}

// Return Success JSON-RPC response
add_file_die(0, $filePath);

function add_file_die($code=100, $message="Error") {
	$json = array('jsonrpc'=>'2.0', 'id'=>'id');
	if($code) {
		header("HTTP/1.1 400");
		$json['error'] = array('code'=>$code, 'message'=>$message);
	}
	else {
		header("HTTP/1.1 200");
		$json['result'] = $message;
	}
	echo json_encode($json, fm_settings::json_flags);
	die;
}

