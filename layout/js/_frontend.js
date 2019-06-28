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

	//-------------------------------------------

	$(".login-page h1 span").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		$(".login-page form").hide();
		$("." + $(this).data("class")).fadeIn(100);
    });

	//-------------------------------------------

	$(".live").keyup(function () {
		$($(this).data('class')).text($(this).val());
    });

    //--------------------------------------------
});