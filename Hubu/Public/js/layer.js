$(".login-1 #user").each(function(){
    var maxwidth=6;
    if($(this).text().length>maxwidth){ $(this).text($(this).text().substring(0,maxwidth)); $(this).html($(this).html()+'…');
    }
});
$('a#m-nav-other').click(function () {
     $(this).removeClass().addClass("btn btn-warning").siblings().removeClass().addClass('btn btn-link');
});
$(function (){
    $("#appurl").popover({
        trigger : 'hover',
        html:true,
        placement:'bottom'
    });
	$("#appurl2").popover({
        trigger : 'hover',
        html:true,
        placement:'left'
    });
});
function iFrameHeight() {   
	var ifm= document.getElementById("iframepage");   
	var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;   
	if(ifm != null && subWeb != null) {
		ifm.height = subWeb.body.scrollHeight;
		ifm.width = subWeb.body.scrollWidth;
	}   
}



    
