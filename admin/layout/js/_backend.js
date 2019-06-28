$(document).ready(function () {
	"use strict";

    $("select").selectBoxIt({autoWidth: false});

    //---------------------------------------

	$("[placeholder]").focus(function () {
		$(this).attr("data-text", $(this).attr("placeholder"));
		$(this).attr("placeholder", "");
	}).blur(function(){
		$(this).attr("placeholder", $(this).attr("data-text"));
	});

	//-----------------------------------------

	$('.show-password').hover(function () {
		$('.password').attr('type', 'text');
    },function () {
        $('.password').attr('type', 'password');
    });
	
	//--------------------------------------------
	
	$(".confirm").click(function () {
		return confirm("Are you sure that you want to delete this member?");
    });

	//--------------------------------------------

	$(".cat h3").click(function () {
		$(this).next(".full-view").fadeToggle(200);
    });

	//-------------------------------------------

	$(".option span").click(function () {
		$(this).addClass("active").siblings("span").removeClass("active");
		if($(this).data("view") == "full")
			$(".cat .full-view").fadeIn(200);
		else
			$(".cat .full-view").fadeOut(200);
    });

	//--------------------------------------------

	$(".child-link").hover(function () {
		$(this).find(".show-delete").fadeIn(200);
    },function () {
        $(this).find(".show-delete").fadeOut(200);
    });

});