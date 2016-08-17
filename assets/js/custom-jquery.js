var obj = new Object();
obj.no_file_dragged = "Drag Zip File Here To Upload";
obj.with_file_dragged = "Drop File Now...";

function bgl360_di_add_file(event){

    //alert(event.dataTransfer.files[0].name);
    console.log("file dropped");
    document.getElementById("bgl360-di-fileupload-message").innerHTML = event.dataTransfer.files[0].name;
    document.getElementById("bgl360-di-fileupload-loading").style.display = 'block';

    setTimeout(function(){
        //alert("submit now");
        document.getElementById('bgl360_dt_upload').click();
    }, 1000);
}

function bgl360_di_click_image_upload() {
    //alert("clicked");
    var l = document.getElementById('bgl360-di-fileupload-file-input');
    l.click();
}

function bgl360_di_change_file_upload() {
    //alert("test");
    //alert(document.getElementById('#bgl360-di-fileupload-file-input').value);
}

function bgl360_di_ondragging() {
    //console.log("dragging enter");

    document.getElementById("bgl360-di-fileupload-message").innerHTML =  "Drop File Now...";

    //$("#bgl360-di-fileupload-message").text(obj.with_file_dragged);
}

function bgl360_di_ondragleave() {
    //console.log("dragging leave");
    //$(".bgl360-di-fileupload-message").text(obj.no_file_dragged);
    document.getElementById("bgl360-di-fileupload-message").innerHTML =  "Drag Zip File Here To Upload";
}

//document.getElementById('bgl360-di-fileupload-file-input').onchange = bgl360_di_uploadOnChange;

function bgl360_di_changeFile(e) {

    //var filename = e.value;
    //var filename = $('#bgl360-di-fileupload-file-input').val().replace(/C:\\fakepath\\/i, '');
    //filename =  filename.split(".")[0];
    //alert(filename);

    var filename = e.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    document.getElementById("bgl360-di-fileupload-message").innerHTML = filename;
    document.getElementById("bgl360-di-fileupload-loading").style.display = 'block';
    setTimeout(function(){
        //alert("submit now");
        document.getElementById('bgl360_dt_upload').click();
    }, 1000);
}

$(function(){
    var drag_and_drop_container = document.getElementById("bgl360-di-fileupload-container");
    drag_and_drop_container.onDragOver = function () {
        // return 0;
        alert("dragging");
    };
    alert("test ing");
    console.log("drop now!");
}());

/*
 $(function(){
 $('#bgl360-di-fileupload-file-input').change(function(){
 var filename = $('#bgl360-di-fileupload-file-input').val().replace(/C:\\fakepath\\/i, '');
 //filename =  filename.split(".")[0];
 //alert(filename);
 document.getElementById("bgl360-di-fileupload-message").innerHTML = filename;
 document.getElementById("bgl360-di-fileupload-loading").style.display = 'block';
 setTimeout(function(){
 //alert("submit now");
 document.getElementById('bgl360_dt_upload').click();
 }, 1000);
 });
 });*/