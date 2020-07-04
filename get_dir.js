const FileMan = {
	process: function(params) {
		//console.log(params);
		if(FileMan.filter) params.filter = FileMan.filter;
		$.get(fm_settings.url + '/get_dir.php', params)
		.done(function(data) {
			//console.log(data);
			try {
				var arr = ["status", "msg", "htm", 'dir'];
				arr.forEach(function(item, index) {
					if(typeof(data[item])!='string') throw item + ' missing';
				});
				if(data.status!='ok') throw data.msg;				
			} catch(e) {
				if(!e) e = "Something bad happened";
				data = {
					status: 'error', 
					msg: e,
					htm: ''
				};
			}
			if(data.htm) { // new directory listing 
				FileMan.show_msg();
				FileMan.els.htm.html(data.htm);
				FileMan.dir = data.dir;
				$('li .process').click(function() {
					var listitem = $(this).closest('li')[0];
					var method = $(this).attr('data-method') + '_' + FileMan.item.class(listitem);
					if(fm_settings.perms.includes(method)) { // Permission granted 
						FileMan.show_msg(method + ': ' + listitem.title, 'clock');
						if(method in FileMan) {
							FileMan[method](listitem);
						}
						else {
							var params = {};
							params[method] = listitem.title;
							FileMan.process(params);
						}
					}
					else FileMan.show_msg('You are not allowed to ' + method, 'lock');
				});
			}
			FileMan.show_msg(data.msg, data.status);
		});
	},
	init: function(selector=false, fm_path='', filter='') {
		//console.log(fm_path);
		if(FileMan.head) {
			for(key in FileMan.head) {
				item = FileMan.head[key];
				var el = document.createElement(item[0]);
				var attribs = item[1];
				for(attr_name in attribs) el[attr_name] = attribs[attr_name];
				$('head').append(el);
				//console.log(el);
			}
			FileMan.head = false;
		}
		if(selector) {
			var jq = $(selector);
		}
		else {
			if(!FileMan.dialog) {
				FileMan.dialog = $('<div id="fm-main"><div>').dialog({
					autoOpen: false,
					height: $(window).height()*.95,
					width: $(window).width()*.95,
					modal: true,
				});
			}
			var jq = FileMan.dialog;
		}
		jq.html('<div class="fileman"><ul class="msg"></ul><div class="buttonbar">'+FileMan.buttonbar+'</div><div class="htm"></div></div>');
		FileMan.els = {
			msg: jq.find('.msg'),
			htm: jq.find('.htm'),
		};
		
		FileMan.filter = filter;
		FileMan.process({get_dir:fm_path});
		return jq;
	},
	filter: 0,
	dialog: 0,
	head: [
		['link', {rel:"stylesheet", type:"text/css", href:fm_settings.url+'/style.css'}]
	],
	els: {},
	dir: '',
	buttonbar: '',
	show_msg: function(msg='', status=0) {
		if(!status) FileMan.els.msg.html('');
		else {
			if(!msg) msg = '-';
			state = status=='error' ? 'error' : 'highlight';
			FileMan.els.msg.append('<li class="ui-state-'+state+' icon-'+status+'">'+msg+'</div>');
		}
	},
	preview_file: function(listitem) {
		var url = FileMan.item.url(listitem);
		if(!url) {
			var basename = FileMan.item.basename(listitem);
			FileMan.show_msg(basename+' can not be previewed', 'error');
			return 0;
		}
		var win_width = $(window).width();
		var win_height = $(window).height();
		var width = Math.min(win_width, win_height * 1.2);
		var height = Math.min(win_height, win_width * 1.2);		
		var dims = {
			width: width,
			height: height,
			left: (win_width - width) / 2,
			top: (win_height - height) / 2,
			menubar: 0,
			status: 0,
			toolbar: 0
		};
		let dims_txt = [];
		for(let key in dims) dims_txt.push(key + '=' + dims[key]);
		window.open(url, "preview", dims_txt.join(','));
	},
	get_file: function(listitem) {
		alert(FileMan.item.html(listitem));
	},
	del_file: function(listitem) {
		if(confirm("Delete '" + FileMan.item.basename(listitem) + "'?")) {
			FileMan.process({del_file: listitem.title});
		}
	},
	item: {
		type: function(listitem) { 
			return listitem.getAttribute("data-type");
		},
		url: function(listitem) {
			return listitem.getAttribute("data-url");
		},
		basename: function(listitem) {
			var ret = listitem.title;
			ret = ret.replace(/^.*?([^\\\/]*)$/, '$1');
			ret = ret.replace(/^([^\.]*).*$/, '$1');
			return ret.replace(/[-_\.]/g, " ");
		},
		'class': function(listitem) {
			return listitem.getAttribute('class');
		},
		html: function(listitem) {
			var type = FileMan.item.type(listitem);
			var url = FileMan.item.url(listitem);
			var basename = FileMan.item.basename(listitem);
			if(type=='image') return '<img src="'+url+'" title="'+basename+'">'; 
			return '<a href="'+url+'">'+basename+'</a>';
		}
	},
	dlg: { }
};

