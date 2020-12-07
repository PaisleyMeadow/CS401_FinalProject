/**
 * Wrapped in ready function so all the elements are loaded
 */
$(document).ready(function() {

    //account options
$("#hamburger").click(function(){
    if($("#user-options").css("visibility") == "hidden"){ 
        $("#user-options").css("visibility", "visible");
    }
    else{ 
        $("#user-options").css("visibility", "hidden");
    }
});

//logout button
$("#logout").click(function(){
    $.ajax({
        type: "POST",
        url: "logout.php",
        success: function(data) { 
           window.location.replace("index.php");
        },
        error: function () {
            alert("Sorry, could not logout");
        }
    });
});

//delete account D:
$("#delete-account").click(function(){
    var del = confirm("Are you sure you want to delet your account? This cannot be undone.");

    if(del){
        $.ajax({
            type: "POST",
            url: "delete-account.php",
            success: function(data) { 
               window.location.replace("index.php");
            },
            error: function () {
                alert("Sorry, could not delete account.");
            }
        });
    }
});

/**
 * Creating new workspace
 */
$("#plus-tab").click(function(){
    if($(this).hasClass("plus-tab-clicked")){
        $("#add-new-workspace-container").fadeOut();
    }
    else{
        $("#add-new-workspace-container").fadeIn();
    }
    $(this).toggleClass("plus-tab-clicked");
    
});

$("#new-workspace-cancel").click(function(){
    $("#plus-tab").removeClass("plus-tab-clicked");
    $("#add-new-workspace-container").fadeOut();
});

//create color picker for creating new workspace
var wpickr = createColorPicker("#new-workspace-color");

//fills in input with color
wpickr.on('init', instance =>{
    $("#new-workspace-color").val(wpickr.getSelectedColor().toHEXA().toString(0));
});
wpickr.on('save', instance =>{
    $("#new-workspace-color").val(wpickr.getSelectedColor().toHEXA().toString(0));
    wpickr.hide();
});
//hides on cancel
wpickr.on('cancel', instance =>{
    wpickr.hide();
});

$("#new-workspace-form").submit(function(e){
    e.preventDefault();
    var values = $("form").serialize();
    var name = $("form").find('input[name="workspace-name"]').val();
    var color = $("form").find('input[name="workspace-color"]').val();

    $.ajax({
    type: "POST",
    url: "addWorkspace.php",
    data: values,
    success: function(data) { 
        if(data == 0){

            //hide form
            $("#add-new-workspace-container").fadeOut();

            //add new tab
            var newTab = '<a href="workspace.php?name='+ name + '" class="workspace-tabs ubuntu-font">' + name + '</a>';
            $("#plus-tab").before(newTab);

            //if on all page, add new square
            if(window.location.pathname == "/app.php"){
                $("#no-workspaces").remove();

                var newSquare = '<a href="workspace.php?name=' + name + '" class="workspace-icon ubuntu-font" style="background-color:' + color + ';">' + name +'</a>';
                $("#workspace-icons-container").append(newSquare);
            }
        }
        else{   //error occured
            alert("Workspace name already in use.");
            $("#plus-tab").trigger("click");
        }
    },
    error: function () {
        alert("Could not create new workspace.");
    }
    }); 
});

});
/////end of document wrap

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