/*
FileMan.head.push(['script', {type:'text/javascript', charset:'UTF-8', src:'/INC/plupload-2.3.6/js/plupload.full.min.js'}]);
FileMan.head.push(['script', {type:'text/javascript', charset:'UTF-8', 
	src:'/INC/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js'}]);
FileMan.head.push(['link', {type:'text/css', rel:'stylesheet', href:'/INC/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css'}]);
*/

var url = fm_settings.url + '/plupload'
console.log(url);

FileMan.head.push(['script', {type:'text/javascript', charset:'UTF-8', src: url+'/plupload.full.min.js'}]);
FileMan.head.push(['script', {type:'text/javascript', charset:'UTF-8', src: url+'/jquery.plupload.queue.min.js'}]);
FileMan.head.push(['link', {type:'text/css', rel:'stylesheet', href: url+'/jquery.plupload.queue.css'}]);

const dlg_add_file = {
	selector: false,
	open: function(destpath) {
		if(dlg_add_file.selector) dlg_add_file.selector.dialog('open');
		else {
			dlg_add_file.selector = $('<div id="fm-add_file"></div>')
			.html('<div>Your browser does not support uploads.</div><pre></pre>')
			.dialog({
				height: 500,
				width: 575,
				modal: true,
				close: function() {
					dlg_add_file.close();
				}
			});
		}
		
		if(!destpath.endsWith('/')) destpath += '/';
		dlg_add_file.selector.find('pre').html('Destination: ' + destpath);
		
		var mime_types = [];
		for(type in fm_settings.upload_types) {
			if(!FileMan.filter || type==FileMan.filter) {
				mime_types.push({title:type, extensions: fm_settings.upload_types[type]});
			}
		}
		dlg_add_file.selector.find('div').pluploadQueue({
			// General settings
			runtimes : 'html5',
			url: fm_settings.url + '/add_file.php', 

			max_file_count: 20,
			chunk_size: '1mb',

			multipart_params: {
				destpath: destpath
			},

			filters: {
				max_file_size : '400kb',
				prevent_duplicates: true,
				mime_types: mime_types
			},

			// Rename files by clicking on their titles
			rename: true,

			// Sort files
			sortable: true,
			dragdrop: true,

			// Views to activate
			views: {
				list: true,
				thumbs: true, 
				active: 'thumbs'
			},
			init: {
				FileUploaded: function(uploader, file, result) {
					var error = {code: 0, message: 'Error'};
					try {
						var filename = file.name;
						obj = JSON.parse(result.response);
						if(typeof(obj.error) !== 'undefined') {
							error.code = typeof(obj.error.code)=='undefined' ? 9999 : obj.error.code ;
							error.message = typeof(obj.error.message)=='undefined' ? 'Undefined error' : obj.error.message ;
						}
					} catch(e) {
						error.code = 9999;
						error.message = e;
					}
					if(error.code) {
						uploader.trigger("Error", error);
						return false;
					}
					dlg_add_file.selector.find('pre').append("\n- " + filename);
				},
				Error: function(uploader, error) {
					var message = 'error';
					try {
						message = error.message;
						if(typeof(error.response) == 'string') {
							response = JSON.parse(error.response);
							if(typeof(response.error.message) != 'undefined') message += ' ' + response.error.message;
						}
					} catch(e) {
						message += '(' + e + ')';
					}
					dlg_add_file.selector.find('pre').append("\n* " + message);
				}
			}
		});
	},
	close: function() {
	}
}
FileMan.buttonbar += '<button data-process="add_file" title="upload files" onclick="FileMan.dlg.add_file();"></button>';

$(function() {
	$(function() { 
		FileMan.dlg.add_file = function() {
			dlg_add_file.close = function() { 
				FileMan.process({get_dir: FileMan.dir});
			}
			dlg_add_file.open(FileMan.dir);
		};
	});
});

