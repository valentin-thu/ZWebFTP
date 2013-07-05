
	$(document).ready(function(){
		$('a').click(function(){
			if(typeof($(this).data('modal')) != 'undefined'){
				openModal($(this).attr('href'));
			}		
		});
		
		$('input[data-filter=integer]').bind('keydown', function(e){
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||  
	       	  (event.keyCode == 65 && event.ctrlKey === true) || 
	          (event.keyCode >= 35 && event.keyCode <= 39) ||
		 	  ((event.keyCode >= 48 && event.keyCode <= 57) && event.shiftKey === true)){
				return;
	        }else{
	            if((event.keyCode < 96 || event.keyCode > 105 ) || 
	              ((event.keyCode >= 48 && event.keyCode <= 57) && event.shiftKey !== true)){
	            	if(event.preventDefault){ 
	                    event.preventDefault(); 
	                }else{ 
	                	event.returnValue = false; 
	                }
	            }   
	        }
		});
		
		$('body').on('click', '#mask', function(){
			closeModal('#'+$('.modal-active').attr('id'));
		});
		
		$('body').on('click', '.modal-close', function(){
			closeModal('#'+$('.modal-active').attr('id'));
		});
		
		$('body').on('click', 'button[data-action=close]', function(){
			closeModal('#'+$('.modal-active').attr('id'));
		});
		
		$('body').keydown(function(evt){
			if(evt.keyCode == 13){
				$('.modal-active button[data-action=valid]').click();
			}
		});
		
		$('body').on('click', 'button[data-action=valid]', function(){
			var url = $('.modal-active').data('submit');
			$.ajax({
				type: 'POST',
				url : url,
				data : $('.modal-active form').serialize(),
				success : function(msg){
					
					$('.modal-active form').remove();
					$('.modal-active .modal-content').append(msg);
					
					if($('.modal-active form').data('hidden') != false){
						setTimeout(function(){
							closeModal('#'+$('.modal-active').attr('id'));
						}, 1000);
					}
					
					if($('.modal-active form').data('reload') != false){
						location.reload();
					}
					
				}
			});
		});
	});

	/**
	 * Ajoute l'option alsoResizeReverse pour le plugin resizable
	 * Permet d'appliquer un alsoResize inversé
	 */
	$.ui.plugin.add("resizable", "alsoResizeReverse", {
		start: function () {
			var that = $(this).data("ui-resizable"),
				o = that.options,
				_store = function (exp) {
					$(exp).each(function() {
						var el = $(this);
						el.data("ui-resizable-alsoresize-reverse", {
							width: parseInt(el.width(), 10), height: parseInt(el.height(), 10),
							left: parseInt(el.css("left"), 10), top: parseInt(el.css("top"), 10)
						});
					});
				};
	
			if (typeof(o.alsoResizeReverse) === "object" && !o.alsoResizeReverse.parentNode) {
				if (o.alsoResizeReverse.length) { o.alsoResizeReverse = o.alsoResizeReverse[0]; _store(o.alsoResizeReverse); }
				else { $.each(o.alsoResizeReverse, function (exp) { _store(exp); }); }
			}else{
				_store(o.alsoResizeReverse);
			}
		},
		resize: function (event, ui) {
			var that = $(this).data("ui-resizable"),
				o = that.options,
				os = that.originalSize,
				op = that.originalPosition,
				delta = {
					height: (that.size.height - os.height) || 0, width: (that.size.width - os.width) || 0,
					top: (that.position.top - op.top) || 0, left: (that.position.left - op.left) || 0
				},
	
				_alsoResizeReverse = function (exp, c) {
					$(exp).each(function() {
						var el = $(this), start = $(this).data("ui-resizable-alsoresize-reverse"), style = {},
							css = c && c.length ? c : el.parents(ui.originalElement[0]).length ? ["width", "height", "top", "left"] : ["width", "height", "top", "left"];
	
						$.each(css, function (i, prop) {
							var sum = (start[prop]||0) - (delta[prop]||0);
							if (sum && sum >= 0) {
								style[prop] = sum || null;
							}
						});
	
						el.css(style);
					});
				};
	
			if (typeof(o.alsoResizeReverse) === "object" && !o.alsoResizeReverse.nodeType) {
				$.each(o.alsoResizeReverse, function (exp, c) { _alsoResizeReverse(exp, c); });
			}else{
				_alsoResizeReverse(o.alsoResizeReverse);
			}
		},
		stop: function () {
			$(this).removeData("resizable-alsoresize-reverse");
		}
	});
	
	function openModal(idModal){
		var title = $(idModal).data('title');
		var modal = idModal.split('#');
		
		if($('.id-modal-'+modal[1]).size() == 0){
			if($('#mask').size() == 0){
				$('body').append('<div id="mask"></div>');
			}else{
				$('#mask').fadeIn();
			}
			
			$(idModal).addClass('modal-active');
			$(idModal).wrap('<div class="modal-contener id-modal-'+modal[1]+'"></div>');
			$(idModal).prepend('<img class="modal-close" src="Images/Images/ico_close.png" alt="Fermer"/>');
			$(idModal).prepend('<div class="modal-header">'+title+'</div>');
			$(idModal).show();
			$('.id-modal-'+modal[1]).animate({ top: '100px', opacity: 'toggle' }, 'slow');
		}
	}
	
	function closeModal(idModal){
		var modal = idModal.split('#');
		$('.id-modal-'+modal[1]).animate({ top: '-200px', opacity: 'toggle' }, 'slow').queue(function(){
		
			origin = $(idModal).data('origin');
			
			$('#mask').fadeOut();
			$.ajax({
				type : 'POST',
				url : origin,
				async: false,
				success : function(msg){
					//console.log(msg);
					$('.id-modal-'+modal[1]).html(msg);
				}
			});
			$(idModal).unwrap();
			$(idModal+' .modal-close').remove();
			$(idModal+' .modal-header').remove();
			$(idModal).removeClass('modal-active');
			$(idModal).hide();
	
			$(this).dequeue();
		});
	}