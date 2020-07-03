<?php
require_once __DIR__ . '/settings.php'; 
if(!fm_settings::perms('get_dir')) return; 

$settings = array(
	'perms' => fm_settings::$perms,
	'url' => fm_settings::url(),
	'upload_types' => fm_settings::upload_types
);
?>
<script>const fm_settings=<?php echo json_encode($settings);?></script>
<?php foreach($settings['perms'] as $perm) {
	$src = "$settings[url]/$perm.js";
	if(file_exists(fm_settings::url_root . $src)) { ?>
	<script type="text/javascript" src="<?php echo $src;?>"></script>
	<?php } 
}