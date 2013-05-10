$(document).ready(function()
{
	var tempo;
	
	$("input").focus(function(){ 
		$(this).parents("td").find("span").addClass("hover");
		tempo = $(this).val();
		$(this).val('');
	}).focusout(function(){	
		$(this).parents("td").find("span").removeClass("hover");
		if($(this).val() == ""){ $(this).val(tempo); }			
	});
	
	$(".toggle-data").click(function(){
		$(this).parent().css('background-color', 'rgba(0, 0, 0, 0.35)');
		$(this).parent().find('ul').show();
		
		$(this).parent().find('ul').mouseleave(function(){			
			$(".toggle-data").parent().find('ul').hide();
			$(".toggle-data").parent().css('background-color', 'transparent');			
		});
		
	});
});

