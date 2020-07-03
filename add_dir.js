//console.log('FileMan.add_dir');
FileMan.buttonbar += '<button data-process="add_dir" title="Create folder" onclick="FileMan.dlg.add_dir.open();"></button>';
	
FileMan.dlg.add_dir = {
	open: function() {
		$('#fm-add_dir')
			.html('<p><label>Path:</label> '+FileMan.dir+'</p>' +
			'<p><label>Directory:</label> <input type="text" class="param" value=""></p>')
			.dialog('open');
	},
	process: function() {
		var param = $('#fm-add_dir .param').val();
		if(param) FileMan.process({add_dir:FileMan.dir + param});
		FileMan.dlg.add_dir.close();
	},
	close: function() {
		$('#fm-add_dir').dialog("close");
	},
	dlg: $('<div id="fm-add_dir" title="Create new folder"></div>').dialog({
		autoOpen: false,
		height: 250,
		width: 350,
		modal: true,
		buttons: { 
			OK: function() { FileMan.dlg.add_dir.process() }, 
			Cancel: function() { FileMan.dlg.add_dir.close() }
		}
	})
};
$('#fm-add_dir').keyup(function(e) {
	if(e.keyCode==13) FileMan.dlg.add_dir.process();
});

