(function() {
	
	function traverseFileTree(item, path) {
		path = path || "";
		if (item.isFile) {
			// Get file
			item.file(function(file) {
				//ParseFile(file);
				UploadFile(file);
			});
		} else if (item.isDirectory) {
			// Get folder contents
			var dirReader = item.createReader();
			dirReader.readEntries(function(entries) {
				for (var i=0; i<entries.length; i++) {
					traverseFileTree(entries[i], path + item.name + "/");
				}
			});
		}
	}
	
	function $id(id) {
		return document.getElementById(id);
	}

	function Output(msg) {
		$('#messages').css({'border':'1px #000 solid'});
		$('#messages').html(msg);
	}

	function FileDragHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}

	function FileSelectHandler(event) {
		FileDragHover(event);
	  
		var items = event.target.files || event.dataTransfer.items;
		for (var i=0; i<items.length; i++) {
			if(typeof items[i]['webkitGetAsEntry'] !== 'undefined'){
				var item = items[i].webkitGetAsEntry();
				if (item) {
					traverseFileTree(item);
				}
			}else{
				for (var i = 0, f; f = items[i]; i++) {
					//ParseFile(f);
					UploadFile(f);
				}
			}
		}
	}
	
	function unitySize(size){
		
		size = parseInt(size);
	
		if(size < 1024){
			return size+' octets';
		}else{
			if(size < (1024*1024)){
				return (size/1024).toFixed(2)+' Ko';
			}else{
				if(size < (1024*1024*1024)){
					return (size/(1024*1024)).toFixed(2)+' Mo';
				}else{
					if(size < (1024*1024*1024*1024)){
						return (size/(1024*1024*1024)).toFixed(2)+' Go';
					}else{
						if(size < (1024*1024*1024*1024*1024)){
							return (size/(1024*1024*1024*1024)).toFixed(2)+' To';
						}
					}
				}
			}
		}
	}
	
	function unityTime(time){
		time= parseInt(time);
		
		if(time < 2){
			return time+' seconde';
		}else{
			if(time < 60){
				return time+' secondes';
			}else{
				if(time < (60*60)){
					return Math.floor(time / 60)+' min '+(time%60)+' sec';
				}else{
					if(time < (60*60*24)){
						return Math.floor((time / (60*60)))+' h '+Math.floor((time%(60*60))/60)+' min '+(time%60)+' sec	';
					}else{
						return Math.floor((time / (60*60*24)))+' j '+Math.floor((time%(60*60*24))/(60*60))+' h '+Math.floor((time%(60*60))/60)+' min '+(time%60)+' sec	';
					}
				}
			}
		}
	}

	// output file information
	/*function ParseFile(file) {

		Output(
			"<p>" + file.name +
			" : <strong>" + unitySize(file.size) +	"</strong></p>"
		);

		// display an image
		if (file.type.indexOf("image") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				Output(
					"<p><strong>" + file.name + ":</strong><br />" +
					'<img src="' + e.target.result + '" /></p>'
				);
			}
			reader.readAsDataURL(file);
		}

		// display text
		if (file.type.indexOf("text") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				Output(
					"<p><strong>" + file.name + ":</strong></p><pre>" +
					e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
					"</pre>"
				);
			}
			reader.readAsText(file);
		}
	}*/

	function UploadFile(file) {
		
		formdata = new FormData();
		var xhr = new XMLHttpRequest();
		
		if (xhr.upload && file.size <= parseInt($id("MAX_FILE_SIZE").value)) {
			formdata.append("fileselect[]", file);
			
			// start upload
			xhr.open("POST", 'upload.php', true);
		
			xhr.setRequestHeader("X_FILENAME", file.name);
			
			
			// create progress bar
			var o = $id("progress");
			var progress = $('#progress').prepend('<span class="nom">'+file.name+'</span><br /><p style="float:left;"></p> <span class="annuler">Annuler</span> <div style="clear:both;"></div>').children();
			
			// cancel upload
			$(progress[2]).next('span').click(function(){
				xhr.abort();
				$(progress[2]).next('.annuler').fadeOut();
				$(progress[1]).prev('.nom').remove();
				$(progress[2]).prev('br').remove();
				setTimeout(function(){
					$(progress[2]).next('.annuler').remove();
				}, 500);
				
				$(progress[2]).css({'background':'none', 'border':'none', 'color':'#000', 'text-align':'left', 'width':'100%'});
				$(progress[2]).html(file.name+' - <strong>Annuler</strong>');
			});
			
			// progress bar
			xhr.upload.addEventListener("progress", function(e) {
				var pc = parseInt(100 - (e.loaded / e.total * 100));
				$(progress[2]).css({'background-position' : pc+'% 0'});
				$(progress[2]).html('<span style="position:relative;top:2px;">'+(100-parseInt(pc)) +'%</span>');
				
				if((100-parseInt(pc)) == 100){
					$(progress[2]).next('.annuler').fadeOut();
					$(progress[1]).prev('.nom').remove();
					$(progress[2]).prev('br').remove();
					setTimeout(function(){
						$(progress[2]).next('.annuler').remove();
					}, 500);
					
					$(progress[2]).css({'background':'none', 'border':'none', 'color':'#000', 'text-align':'left', 'width':'100%'});
					$(progress[2]).html(file.name+' - <strong>'+unitySize(file.size)+'</strong>');
				}
				
			}, false);

			
			
			// file received/failed
			xhr.onreadystatechange = function(e) {
				if (xhr.readyState == 4) {
					progress.className = (xhr.status == 200 ? "success" : "failure");
				}
			};
			
			xhr.send(formdata);
		
			lastSize = 0;
			
			setInterval(function(){
				$.ajax({
					type:'POST',
					data:'name='+file.name,
					url:'check.php',
					success:function(msg){
						uploadSize = parseInt(msg);
						sizeMax = parseInt(file.size);
						if(uploadSize < sizeMax){
							debitSize = uploadSize - lastSize;
							
							tempsSeconde = Math.round((sizeMax-uploadSize)/debitSize);
							
							debit = unitySize(debitSize)+'/s';
							lastSize = uploadSize;
							
							console.log(((uploadSize * 100) / sizeMax).toFixed(1)+'% - '+debit+' - '+unityTime(tempsSeconde));
						}else{
							clearInterval(this);
						}
					}
				});
			},1000);
				
		}else{
			Output(
				"<p>Le fichier " + file.name +" est trop lourd ("+unitySize(file.size)+"). Maximum " + unitySize($id("MAX_FILE_SIZE").value) + "</p>"
			);
		}
	}
	
	// initialize
	function Init() {
		
		var fileselect = $id("fileselect"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// file drop
			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";

			// remove submit button
		//	submitbutton.style.display = "none";
		}

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}
})();