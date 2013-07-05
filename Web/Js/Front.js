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
	
	if($('tr[data-dossier="'+$directory+'"] span').css('font-weight') == 'bold'){
		$('tr[data-dossier="'+$directory+'"] span').css({'font-weight' : 'normal'});
		$('tr[data-dossier="'+$directory+'"] img.ico-ouverture').attr('src', 'Images/Front/ico_plus.png');
	}else{
		$('tr[data-dossier="'+$directory+'"] span').css({'font-weight' : 'bold'});
		$('tr[data-dossier="'+$directory+'"] img.ico-ouverture').attr('src', 'Images/Front/ico_moins.png');
	}
	
	var next = $('tr[data-dossier="'+$directory+'"]').next().data('dossier');
	if(next != null){
		var check = next.indexOf($directory);
	}else{
		var check = -1;
	}
	
	
	if(check == -1){
		$('tr[data-dossier="'+$directory+'"]').after('<tr class="load"><td>Chargement...</td></tr>');
		
		$.ajax({
			type : 'POST',
			url : 'explorer.html',
			data : 'dir='+$directory+'&data='+$('tr[data-dossier="'+$directory+'"]').data('arbo'),
			success : function (msg){
				$('tr[data-dossier="'+$directory+'"]').next('tr.load').remove();
				$('tr[data-dossier="'+$directory+'"]').after(msg);
				$('tr[data-dossier="'+$directory+'"]').addClass('explorer-active');
				
				/*$('td[data-dossier="'+$directory+'"]').parent('tr').next().hide();
				$('td[data-dossier="'+$directory+'"]').children('ul').slideDown();*/
			}
		});
		
		/*$.ajax({
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
		});*/
	}else{
		if($('tr[data-dossier="'+$directory+'"]').hasClass('explorer-active')){
			
			$('tr[data-dossier="'+$directory+'"]').nextAll('tr[data-dossier*="'+$directory+'"]').each(function(){
				$(this).hide();
			});
			
			//$('li[data-dossier="'+$directory+'"]').children('ul').slideUp();
			$('tr[data-dossier="'+$directory+'"]').removeClass('explorer-active');
			
			/*$('.files').children('div:visible').animate({'width':'0px'}, function(){
				$(this).hide();
			});
			
			direc = $directory.lastIndexOf('%2F');
			nom = $directory.substr(0, direc);
			$('div[data-dossier="'+nom+'"]').css({'display':'block'});
			$('div[data-dossier="'+nom+'"]').animate({'width':'100%'});*/

		}else{
			$('tr[data-dossier="'+$directory+'"]').addClass('explorer-active');
			
			var nbSplit = $directory.split('%2F');
			
			$('tr[data-dossier="'+$directory+'"]').nextAll('tr[data-dossier*="'+$directory+'"]').each(function(){
				
				var nbSplit2 = $(this).data('dossier').split('%2F');
				
				if((nbSplit.length+1) == nbSplit2.length){
					$(this).css({'display':'table-row'});
				}
			});
			
			//$('li[data-dossier="'+$directory+'"]').children('ul').slideDown();
			
			/*$('.files').children('div:visible').animate({'width':'0px'}, function(){
				$(this).hide();
			});
			
			$('div[data-dossier="'+$directory+'"]').css({'display':'block'});
			$('div[data-dossier="'+$directory+'"]').animate({'width':'100%'});*/

		}
	}
	
}