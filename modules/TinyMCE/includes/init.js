tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu",
	theme_advanced_buttons1_add_before : "save,separator",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "example_full.css",
    plugin_insertdate_dateFormat : "%Y-%m-%d",
    plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_link_list.js",
	external_image_list_url : "example_image_list.js",
	flash_external_list_url : "example_flash_list.js",
	file_browser_callback : "fileBrowserCallBack",
	setupcontent_callback: "startResize"
});
	
//function setSubmitValues(){
//	document.frmAction.sContent.value = editor.getHTML()
//}

function startResize(){
	window.onresize = resize_frame
	resize_frame()
	document.body.style.overflow=""
}

function resize_frame(){

	var iX = pxp_winX() - 2
	var iY = pxp_winY() - 90
	
	var oFrame = document.getElementById("mce_editor_0")

	if(iY > 0)
		oFrame.style.height = iY + "px"
	
	if(iX > 0)
		oFrame.style.width = iX + "px"
}