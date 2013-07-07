$(document).ready(function(){
	
	$('#Body').resizable({
		alsoResizeReverse : '#Footer'
	});
	
	$('#SsExplorer').resizable({
		containment: '#Body',
		alsoResizeReverse: '#Content',
		alsoResize: '#Explorer',
		handles : 'e',
		resize : function(){
			$('#SsExplorer').css({'height':'auto'});
			$('#SsExplorer').css({'width':'100%'});
			$('#Content').css({'height':'100%'});
		}
	});
	
	scroll = 0;
	
	$('#Explorer').scroll(function(event){
		
		if(event.target.scrollLeft >= scroll){
			scroll = event.target.scrollLeft;
			$('#SsExplorer div.ui-resizable-handle').css({'right':'-'+scroll+'px'});
		}else{
			scroll = event.target.scrollLeft;
			$('#SsExplorer div.ui-resizable-handle').css({'right':''+scroll+'px'});
		}
	});
	
});

function explorerDir($directory){
	
	if($('span[data-dossier="'+$directory+'"]').css('font-weight') == 'bold'){
		$('span[data-dossier="'+$directory+'"]').css({'font-weight' : 'normal'});
		$('img.ico-ouverture[data-dossier="'+$directory+'"]').attr('src', 'Images/Front/ico_plus.png');
	}else{
		$('span[data-dossier="'+$directory+'"]').css({'font-weight' : 'bold'});
		$('img.ico-ouverture[data-dossier="'+$directory+'"]').attr('src', 'Images/Front/ico_moins.png');
	}
	
	if($('li[data-dossier="'+$directory+'"] ul').size() == 0){
		$('li[data-dossier="'+$directory+'"]').append('<ul><li class="load">Chargement...</li></ul>');
		
		$.ajax({
			type : 'POST',
			url : 'explorer.html',
			data : 'dir='+$directory+'&data='+$('li[data-dossier="'+$directory+'"]').data('arbo'),
			success : function (msg){
				
				$('li[data-dossier="'+$directory+'"] ul').remove();
				$('li[data-dossier="'+$directory+'"]').append(msg);
				$('li[data-dossier="'+$directory+'"] ul').hide();
				$('li[data-dossier="'+$directory+'"] ul').slideDown();
				$('li[data-dossier="'+$directory+'"]').addClass('explorer-active');
				
				/*$('td[data-dossier="'+$directory+'"]').parent('tr').next().hide();
				$('td[data-dossier="'+$directory+'"]').children('ul').slideDown();*/
			}
		});
		
		$.ajax({
			type : 'POST',
			url : 'files.html',
			data : 'dir='+$directory,
			success : function (msg){
				$('.files').children('div').animate({'width':'0px'}, function(){
					$(this).hide();
				});
				$('.files').prepend(msg);
				$('div[data-dossier="'+$directory+'"]').animate({'width':'100%'});
			}
		});
	}else{
		if($('li[data-dossier="'+$directory+'"]').hasClass('explorer-active')){
			
			$('li[data-dossier="'+$directory+'"]').children('ul').slideUp();
			$('li[data-dossier="'+$directory+'"]').removeClass('explorer-active');
			
			$('.files').children('div:visible').animate({'width':'0px'}, function(){
				$(this).hide();
			});
			
			direc = $directory.lastIndexOf('%2F');
			nom = $directory.substr(0, direc);
			$('div[data-dossier="'+nom+'"]').css({'display':'block'});
			$('div[data-dossier="'+nom+'"]').animate({'width':'100%'});

		}else{
			$('li[data-dossier="'+$directory+'"]').addClass('explorer-active');
			$('li[data-dossier="'+$directory+'"]').children('ul').slideDown();
			
			$('.files').children('div:visible').animate({'width':'0px'}, function(){
				$(this).hide();
			});
			
			$('div[data-dossier="'+$directory+'"]').css({'display':'block'});
			$('div[data-dossier="'+$directory+'"]').animate({'width':'100%'});

		}
	}
	
}