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
		
		$('body').on('click', '.ulFilAriane', function(){
			var chemin = '';
			var indice = 0;
			
			if(window.getSelection().extentOffset == 0){

				childrenLi = $(this).children('li');
				
				if($(this).children('input').size() == 0){
					childrenLi.each(function(){
						
						$(this).hide();
						
						indice++;
						if(indice == 2){
							chemin += '/';
							indice = 0;
						}else{
							chemin += $(this).text();
						}
					});
					
					navbar = '<input class="inputNavBar" type="text" value="'+chemin+'"/>';
					
					$(this).append(navbar);
					
					childrenInput = $(this).children('input');
					
					childrenInput.focus(function(){
						$(this).keydown(function(evt){
							if(evt.keyCode == 13){
								
								address = $(this).val();
								address = encodeURIComponent(address.substr(1));
								address = address.replace(/%20/g,'+');
								
								tabAdress = address.split('%2F');
								chemin2 = '';
								
								for(i=0;i<tabAdress.length;i++){
									if(chemin2 != ''){
										chemin2 += '%2F';
									}
									
									chemin2 += tabAdress[i];
									
									bool = (i == (tabAdress.length-1)) ? true : false;
									
									getFiles(chemin2, bool);
								}
								
								
							}
						});
					}).select();
					
					childrenInput.blur(function(){
						childrenLi.each(function(){
							$(this).show();
						});
						childrenInput.remove();
					})
				}
			}
		});
		
	});
	
	function explorerDir($directory, $boolOpen){

		if($('img[data-dossier="'+$directory+'"]').hasClass('open')){
			if($boolOpen != false){
				if($('img[data-dossier="'+$directory+'"]').attr('src') == 'Images/Front/ico_moins.png'){
					$('img[data-dossier="'+$directory+'"]').attr('src', 'Images/Front/ico_plus.png');
					$('img[data-dossier="'+$directory+'"]').removeClass('open');
				}
			}
		}else{
			if($('img[data-dossier="'+$directory+'"]').attr('src') == 'Images/Front/ico_plus.png'){
				$('img[data-dossier="'+$directory+'"]').attr('src', 'Images/Front/ico_moins.png');
				$('img[data-dossier="'+$directory+'"]').addClass('open');
			}
		}
		
		if($('li[data-dossier="'+$directory+'"] ul').size() == 0){
			$('li[data-dossier="'+$directory+'"]').append('<ul style="list-style:none"><li style="padding-left:36px;" class="load"><img style="margin-right:5px;" src="/Images/Images/ajax-loader.gif"/><span style="position:relative;top:1px;">Chargement...</span></li></ul>');
			
			$.ajax({
				type : 'POST',
				url : 'explorer.html',
				async: false,
				data : 'dir='+$directory+'&data='+$('li[data-dossier="'+$directory+'"]').data('arbo'),
				success : function (msg){
					if(msg == ''){
						if($('li[data-dossier="'+$directory+'"]').data('arbo').toString().indexOf('-') != -1){
							indiceArbo = $('li[data-dossier="'+$directory+'"]').data('arbo').split('-');
							valueIndiceArbo = indiceArbo[(indiceArbo.length)-1];
						}else{
							valueIndiceArbo = $('li[data-dossier="'+$directory+'"]').data('arbo');
						}
						
						if(valueIndiceArbo == 0){
							imageNodir = 'ico_nodir_fin';
						}else{
							imageNodir = 'ico_nodir';
						}
						
						$('img[data-dossier="'+$directory+'"]').attr('src', 'Images/Front/'+imageNodir+'.png');
						$('img[data-dossier="'+$directory+'"]').prop('onclick', null);
						$('img[data-dossier="'+$directory+'"]').removeAttr('onclick');
						$('img[data-dossier="'+$directory+'"]').css({'cursor':'default'});
					}
					$('li[data-dossier="'+$directory+'"] ul').remove();
					$('li[data-dossier="'+$directory+'"]').append(msg);
					$('li[data-dossier="'+$directory+'"] ul').hide();
					$('li[data-dossier="'+$directory+'"] ul').slideDown();
					$('li[data-dossier="'+$directory+'"]').addClass('explorer-active');
				}
			});
			
		}else{
			if($('li[data-dossier="'+$directory+'"]').hasClass('explorer-active')){
				
				if($boolOpen != false){
					$('li[data-dossier="'+$directory+'"]').children('ul').slideUp();
					$('li[data-dossier="'+$directory+'"]').removeClass('explorer-active');
				}
	
			}else{
				$('li[data-dossier="'+$directory+'"]').addClass('explorer-active');
				$('li[data-dossier="'+$directory+'"]').children('ul').slideDown();
			}
		}
		
	}
	
	function getFiles($directory, $boolOpen){
		
		$('#SsExplorer span').css({'font-weight':'normal'});
		$('span[data-dossier="'+$directory+'"]').css({'font-weight' : 'bold'});
		
		if($('div[data-dossier="'+$directory+'"]').size() == 0){
			
			$('.files').prepend('<div class="div-mask-files" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color:rgba(223,223,223,0.5);"><div style="margin:auto;width:150px;height:150px;margin-top:300px;color:#000;text-align:center;"><img src="/Images/Images/ajax-loader-grd.gif" /><br/><br/>Chargement...</div></div>');
			explorerDir($directory, false);
			
			$.ajax({
				type : 'POST',
				url : 'files.html',
				data : 'dir='+$directory,
				async:false,
				success : function (msg){
					
					$('.div-mask-files').fadeOut();
					setTimeout(function(){
						$('.files').children('div').animate({'width':'0px'}, function(){
							$(this).hide();
							$(this).removeClass('open');
						});
						$('.div-mask-files').remove();
						$('.files').prepend(msg);
						
						
						
						if($boolOpen != false){
							
							$('div[data-dossier="'+$directory+'"]').animate({'width':'100%'});
							$('div[data-dossier="'+$directory+'"]').addClass('open');
						}
					}, 500);
					
				}
			});
		}else{
			if(!($('div[data-dossier="'+$directory+'"]').hasClass('open'))){
				$('.files').children('div:visible').animate({'width':'0px'}, function(){
					$(this).hide();
					$(this).removeClass('open');
				});
				
				$('div[data-dossier="'+$directory+'"]').css({'display':'block'});
				$('div[data-dossier="'+$directory+'"]').animate({'width':'100%'});
				$('div[data-dossier="'+$directory+'"]').addClass('open');
			}
		}
	}