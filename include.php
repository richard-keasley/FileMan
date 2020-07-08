<?php
require_once __DIR__ . '/settings.php'; 
if(fm_settings::perms('get_dir')) {
	$fm_settings = array(
		'perms' => fm_settings::$perms,
		'url' => fm_settings::url(),
		'max_file_size' => fm_settings::$max_file_size,
		'upload_types' => fm_settings::$upload_types
	);
	?>
	<script>const fm_settings=<?php echo json_encode($fm_settings);?></script>
	<?php foreach($fm_settings['perms'] as $perm) {
		$src = "$fm_settings[url]/$perm.js";
		if(file_exists(fm_settings::$url_root . $src)) { ?>
		<script type="text/javascript" src="<?php echo $src;?>"></script>
		<?php } 
	}
}
else { ?>
<script>
const FileMan = {
	init: function(selector=false) {
		var html = '<div class="ui-state-error icon-error">No access to FileMan</div>';
		return selector ? 
			$(selector).html(html) : 
			$('<div id="fm-main">'+html+'<div>').dialog({
				autoOpen: true,
				modal: true,
			});
	}
};
</script>
<?php }