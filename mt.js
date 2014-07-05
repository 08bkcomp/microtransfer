$("#proform").hide();

$("#droparea").on('dragover', FileDragHover);
$("#droparea").on('dragleave', FileDragHover);
$("#droparea").on('drop', FileUploadHandler);

function FileDragHover(e){
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.type == "dragover" ? "hover" : "");
}

function FileUploadHandler(e){
	e.stopPropagation();
	e.preventDefault();
	FileDragHover(e);
	e.dataTransfer = e.originalEvent.dataTransfer;
	var file = e.dataTransfer.files[0];
	if (file.size > 10485760){
		$("#droptext").html("Files above 10MB are too large :(<br/>Why not try another file?");
	} else {
		$("#droptext").html("Uploading "+ file.name);
		//ajax upload
		var formData = new FormData();
		formData.append("upfile", file);
		var request = new XMLHttpRequest();
		request.open("POST", "upload.php");
		request.send(formData);
		request.onload = function() {
		    if (request.status == 200) {
		      $("#droptext").html(file.name + " was uploaded");
		      $("#droparea").addClass('success');
		      if(file.type != "application/x-php"){
		      	$("#droptext").html("Your code:<br/>"+request.responseText);
		      } else {
		      	$("#droptext").html(request.responseText);
		      }
		    } else {
		      $("#droptext").html("Error " + request.status + " occurred uploading your file.<br/>");
		    }
	  	};
	}
}

$("#downform").keyup(function(event) {
	/* Act on the event */
	if(event.keycode == 13){
		var formData = new FormData();
		formData.append("downcode", $("#codebox").val());
		var request = new XMLHttpRequest();
		request.open("POST", "download.php")
		request.send(formData);
		request.onload = function(oEvent) {
		    if (request.status == 200) {
		      $("#downform").html(request.responseText);
		    } else {
		      $("#downform").html("Error " + request.status + " occurred.<br/>");
			}
		};
	}
});