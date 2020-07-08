//console.log('FileMan.add_dir');
FileMan.buttonbar += '<button data-process="get_settings" title="View settings" onclick="FileMan.dlg.get_settings.open();"></button>';
	
FileMan.dlg.get_settings = {
	open: function() {
		$.get(fm_settings.url + '/get_dir.php', {get_settings:''})
		.done(function(data) {
			try {
				var arr = ["status", "msg", "htm", 'dir'];
				arr.forEach(function(item, index) {
					if(typeof(data[item])!='string') throw item + ' missing';
				});
				if(data.status!='ok') throw data.msg;
				if(!data.htm) throw 'No data';
			} catch(e) {
				if(!e) e = "Something bad happened";
				data = {
					status: 'error', 
					htm: e
				};
			}
			if(data.status=='error') data.htm = '<div class="ui-state-error">'+data.htm+'</li>';
			$('#fm-get_settings').html(data.htm).dialog('open');
		});
	},
	process: function() {
	},
	close: function() {
		$('#fm-get_settings').dialog("close");
	},
	dlg: $('<div id="fm-get_settings" title="Settings"></div>').dialog({
		autoOpen: false,
		height: 600,
		width: 700,
		modal: true,
		buttons: { 
			OK: function() { FileMan.dlg.get_settings.close() }
		}
	})
};
$('#fm-get_settings').keyup(function(e) {
	if(e.keyCode==13) FileMan.dlg.get_settings.close();
});

