/*
 * var ImageUpload={ Title: string,Token:string }
 * */
function image_upload(field, preview,option) {
	$('#dialog').remove();
	var opt=$.extend({
		zIndex:100
	},option);
	$(document.body).prepend('<div id="dialog" style="padding: 3px 0px 0px 0px"><iframe src="index.php?route=common/filemanager&token='+ImageUpload.Token+'&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: ImageUpload.Title,
		close: function (event, ui) {
			var file=window.selectedfile;
			delete window.selectedfile;
			if(!file)return;
			if(preview){
				var psize='';
				if(preview.width && preview.height){
					psize=' width="'+preview.width+'" height="'+preview.height+'"';
				}
				$('#' + preview).replaceWith('<img src="' + file + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');"'+psize+' />');
			}
			if(opt.callback)opt.callback(file);
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false,
		zIndex:opt.zIndex
	});
};
