/**
 * Wrapped in ready function so all the elements are loaded
 */
$(document).ready(function() {

//make elements draggable
//increase size with scroll while draggin
$(".draggable").draggable({
    containment: '.workspace', 
    cancel: '',
    stack: ".draggable"
});
//resize elements with scroll while selected
//using $(document).on() so elements added dynamically will be draggable 
$(document).on("dragstart", ".draggable", function(){ 
    var img = $(this);
    
    $(this).bind("mousewheel DOMMouseScroll", function(e){ 
        var w = img.width(); 

        if(e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0){   //up scroll = decrease size
            if(w > 100){
                img.width(w - 1);
            }
        }
        else{//down scroll = increase size
            if(w > 10){
                img.width(w + 1);
            }
        }
    });
});

//delete element when dragged + dropped over/near delete button
var inDelete = false;

$(document).on("drag", ".draggable", function(){ 

    var delPos = $("#delete-element").position(); 
    var delWidth = $("#delete-element").outerWidth();
    var delHeight = $("#delete-element").outerHeight();

    var pos = $(this).position(); 
    var posRight = pos.left + $(this).outerWidth();
    var posBottom = pos.top + $(this).outerHeight();

    if( (posRight > delPos.left && posRight < (delPos.left + delWidth) ) &&
        posBottom >  delPos.top && posBottom < (delPos.top + delHeight) )
    {
        inDelete = true;
        $("#delete-element").css("background-color", "#e41c34");
        $("#delete-element").css("color", "#8685ef");
    }
    else{
        $("#delete-element").removeAttr("style");
        inDelete = false;
    }
});
//delete on drop 
$(document).on("dragstop", ".draggable", function(){

    $(this).unbind("mousewheel DOMMouseScroll");    //<< unbinds scrolling size increase event

    var del = false;
    if(inDelete){ //ask first!
        del = confirm("Are you sure you want to delete this element?");
    }

    if(del){    //deleting element

        var el; 

        $(this).remove();
        $("#delete-element").css("background-color", "#cbef43");

        //if image, we'll need source
        if($(this).prop("src")){
            el = "id=" + $(this).attr("data-id") + "&isImage=true";
        }
        else{    //if note, need content and color
            el = "id=" + $(this).attr("data-id") + "&isImage=false"; 
        }

        $.ajax({
        type: "POST",
        url: "deleteElement.php",
        data: el,
        success: function(data) { 
            
        },
        error: function () {
            alert("Unable to delete element.");
        }
        }); 
    }
});

/**
 * Sidebar (color choose, edit name, and delete)
 */

//////COLOR PICKER (in sidebar)

try{
    //init the color picker in sidebar
    var pickr = createColorPicker('.color-picker');

    //so when the whole div is clicked, the picker shows
    $("#color").click(function(){
        pickr.show();

        //also hide edit name form to prevent ui bug
        $("#edit-name-form").fadeOut();
    });

    var sidebar = $("#sidebar");
    //when picker is shown, keep sidebar open
    pickr.on('show', instance => { 
            sidebar.addClass("sidebar-hover");
    });
    //when picker is closed, let sidebar go back
    pickr.on('hide', instance => { 
        sidebar.removeClass("sidebar-hover");
    });

    //close pickr when cancel is clicked
    pickr.on('cancel', instance => {
        pickr.hide();
    });

    //when color is saved, load into database and reload page/workspace
    pickr.on('save', instance =>{
        var colorObj = { color : pickr.getColor().toHEXA().toString()}; 
        //need to pass hex value and workspace name
        $.ajax({
            type: 'POST',
            url: "saveWorkspaceColor.php",
            data: colorObj,
            success: function() {
                
            },
            error: function () {
            alert("Unable to save color.");
            }
        });

        //change workspace color on site so we don't have to wait for the db
        var name = getURLdata("name");
        $(`#${name}`).css("background-color", colorObj["color"]);
        $(`#${name}`).parent().css("background-color", colorObj["color"]);

        //close color picker
        pickr.hide();
    });
}
catch(e){ //just to catch error on app.php from not having sidebar
    
}

//EDIT WORKSPACE NAME
$("#edit").click(function(){

    $("#edit-name").fadeIn();
    $("#workspace-name-input").val(getURLdata("name"));

    //keep sidebar open until name edit submitted                                                 
    sidebar.addClass("sidebar-hover");
});

$(".workspace-input-submit").click(function(){
    $("#edit-name").css('display', 'none');
    sidebar.removeClass("sidebar-hover");
});

$("#edit-name-form").submit(function(e){
    var values = $("form").serialize();
    var newName = $("#workspace-name-input").val();

    if(newName != getURLdata("name")){  //don't send to back end if no change in name
        $.ajax({
        type: "POST",
        url: "editWorkspaceName.php",
        data: values,
        success: function() { 
            window.location = "workspace.php?name=" + encodeURIComponent(newName);
        },
        error: function () {
            alert("Could not change workspace name.");
        }
        });
    }
    else{
        e.preventDefault();
    }
});


//DELETE WORKSPACE
$("#trash").click(function(){
    //confirm pop-up
    var del = confirm("Are you sure you want to delete this workspace?");

    if(del){
        $.ajax({
            type: 'POST',
            url: "deleteWorkspace.php",
            success: function() {
                window.location = "app.php";
            },
            error: function () {
              alert("Unable to delete workspace.");
            }
        });
    }
});

/**
 * Adding new elements
 */
$("#open-add-element").click(function(){
    $("#new-element-container").fadeIn();
});
$("#close-new-element").click(function(e){
    e.preventDefault();
    $("#new-element-container").fadeOut();
});

//create pickr for note color
var npickr = createColorPicker("#note-color-picker");

//fills in input with color
npickr.on('save', instance =>{
    $("#note-color-picker").val(npickr.getSelectedColor().toHEXA().toString(0));
    npickr.hide();
});
//hides on cancel
npickr.on('cancel', instance =>{
    npickr.hide();
});

//showing image or note upload options based on selection
$("#note-opt").click(function(){
    if($(this).is(':checked')){
        $("#note-color-div").fadeIn();
    }
    if($("#upload-image-div").is(":visible")){
        $("#upload-image-div").fadeOut();
    }
});

$("#image-opt").click(function(){
    if($(this).is(':checked')){
        $("#upload-image-div").fadeIn();
    }
    if($("#note-color-div").is(":visible")){
        $("#note-color-div").fadeOut();
    }
});

//dragging and dropping image to upload
// $("#new-element-container").on("dragenter", function(e){
//     e.preventDefault();
//     $(this).css("border", "#e41c34 5px solid")
// });
// $("#new-element-container").on("dragover", function(e){
//     e.preventDefault();
// });
// $("#new-element-container").on("drop", function(e){
//     e.preventDefault();
//     $(this).css("border", "none")

//     if($("#upload-image-div").is(":visible")){
//         var image = e.originalEvent.dataTransfer.files[0] || e.originalEvent.dataTransfer.getData("text/html");
//         var src = $(image).prop('src');
//         var preview = image.name || image;

//         //add to url input
//         $("#new-element-form input[name='img_url']").val(src);

//         //replace upload options with image preview (either actual image or file name)
//         if(!$("#img-to-upload").length){
//             $("#upload-image-div").append('<label id="img-to-upload">Uploading: ' + preview +'</label>');
//         }
//     }
// });
// //make entire workspace drag and drop for images
// $(".workspace").on("dragenter", function(e){
//     e.preventDefault();
//     $(".workspace-container").css("border", "#e41c34 5px solid")
// });
// $(".workspace").on("dragover", function(e){
//     e.preventDefault();
// });
// $(".workspace").on("drop", function(e){
//     e.preventDefault();
//     $(".workspace-container").css("border", "none")

//     var image;
//     var preview;

//     if(e.originalEvent.dataTransfer.files[0]){ alert("Drag and drop doesn't work with local files :(");
//         image = e.originalEvent.dataTransfer.files[0];
//         preview = image.name;
//     }
//     if(e.originalEvent.dataTransfer.getData("text/html")){
//         image = $(e.originalEvent.dataTransfer.getData("text/html")).prop("src");
//         preview = image;

//         //add to url input
//         $("#new-element-form input[name='img_url']").val(image); 
//     }

//     //display image preview (either actual image or file name)
//     $("#upload-image-div").append('<label id="img-to-upload">Uploading: ' + preview +'</label>');

//     //check image box and trigger form submit
//     $("#image-opt").prop("checked", true);
//     $("#new-element-form").submit();

// });

//display file name on from desktop upload
$("#img").change(function(){
    var imgName = $("#img")[0].files[0].name;
    $("#upload-image-div").append('<label id="img-to-upload">Uploading: ' + imgName +'</label>');
});
//now to upload the image or note
$("#new-element-form").on('submit', function(e){

    e.preventDefault();

    var data = new FormData(this); 
    var wname = getURLdata("name");
    var noteColor = $("#note-color-picker").val();
    var isImage = false;
    var fileName;

    //see what option was checked
    if($("#image-opt").is(":checked")){ 
        isImage = true;

        if($(this).find('input[name="img_url"]').val() == ""){
            fileName = "bin/images/" + $("#img")[0].files[0].name;
        }
        else{
            fileName =  $(this).find('input[name="img_url"]').val();
        }

        //don't submit if no image is given
        if(fileName == ""){
            alert("No image given.");
            return 0;
        }
    }

    $.ajax({
        type: "POST",
        url: "upload-element.php",
        data: data,
        enctype: "multipart/form-data", //not sure if this is necessary but 
        processData: false,
        contentType: false,
        success: function(data) { //data is db id of image
            if(!isImage){
           //add note to workspace on page
                $("#" + wname).append('<textarea class="ubuntu-font draggable" data-id="' + data + '" style="background-color:' + noteColor + ';"></textarea>');
            }
            else{ //add image
                $("#" + wname).append('<div><img class="draggable" data-id="' + data + '" src="' + fileName + '"></div>');                
            }
            
            //redo draggables so new element is draggable
            $(".draggable").draggable({
                containment: '.workspace', 
                cancel: '',
                stack: ".draggable"
            });
            //clear file input
            $("#img").val('');
            $("#new-element-container").fadeOut();
           
        },
        error: function () {
            alert("Sorry, could not add element.");
        }
    });
});

//save content of notes in database
$("textarea").keydown(function(){

    //setting time out so that user can finish typing before saving 
    setTimeout(() => {

        var content = "content=" + $(this).val() + "&id=" + $(this).attr("data-id");

        $.ajax({
        type: "POST",
        url: "upload-note-input.php",
        data: content,
        success: function(data) { 
            
        },
        error: function () {
            alert("Sorry, could not edit note.");
        }
    })
    }, 1000);
});


}); 
/////////end of document wrap

//Gets data from url (where "name" is ?name=X)
function getURLdata(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }
    else{
        return decodeURIComponent(results[1]) || 0;
    }
}

// Color picker from: https://github.com/Simonwep/pickr
function createColorPicker(elName){
    
    // Simple example, see optional options for more configuration.
    return Pickr.create({
        el: elName,
        theme: 'monolith', // or 'monolith', or 'nano'
    
        //options
        closeWithKey: 'Escape',
        default: '#999999',
        swatches: null,
        useAsButton: true,
    
        swatches: [
            '#999999',
            '#cbef43',
            '#e41c34',
            'rgba(103, 58, 183, 1)'
        ],
    
        components: {
    
            // Main components
            preview: true,
            opacity: false,
            hue: true,
    
            // Input / output Options
            interaction: {
                input: true,
                cancel: true,
                save: true
            }
        }
    });
}