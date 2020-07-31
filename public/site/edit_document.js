$(document).ready(function(){
    $("#tags_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("div#tags .dropdown-menu li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        console.log("tags_input");
    });
    $("#document_has_document_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("div#document_has_document .dropdown-menu li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        console.log("document_has_document_input");
    });
    $("#published_at_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("div#published_at .dropdown-menu li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        console.log("published_at_input");
    });

    $("#boletim_document_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("div#published_at .dropdown-menu li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        console.log("boletim_document_input");
    });
});


$(".dropdown-menu li a").click(function(){
    console.log("dropdown-menu li a");

    $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
});

$("div#document_has_document .dropdown-menu li").click(function(){
    console.log("dropdown-menu document_has_document");
    $(this).parents(".dropdown ").find('#document_has_document').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown ").find('#document_has_document').val($(this).data('value'));
});

$("div#published_at .dropdown-menu li").click(function(){
    console.log("dropdown-menu published_at");
    $(this).parents(".dropdown ").find('#dropdownPublishedAt').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown ").find('#dropdownPublishedAt').val($(this).data('value'));

});

$("div#tags_ul .dropdown-menu li").click(function(){
    console.log("dropdown-menu published_at");
    $(this).parents(".dropdown ").find('#tags').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown ").find('#tags').val($(this).data('value'));
});



function new_file(i) {
    console.log("new_file_text" + i);
    $("#new_file_text" + i).css("display", "none");
    var input = document.getElementById('new_file'+i);

    var input = event.srcElement;
    var fileName = input.files[0].name;
    var infoArea = document.getElementById('new_file_text' + i);
    $("#current_file" + i).removeClass('current_file_text');
    $("#current_file" + i).addClass('remove_file_text');
    $("#new_file_text" + i).removeClass('remove_file_text');
    $("#new_file_text" + i).addClass('new_file_text');
    $("#new_file_text" + i).css("display", "block");
    $("#remove_field" + i).fadeIn();
    infoArea.textContent = (fileName);
}

function remove_file(i) {
    console.log("remove_file" + i);
        $("#current_file" + i).removeClass('current_file_text');
        $("#current_file" + i).addClass('remove_file_text');
        $("#new_file_text" + i).removeClass('new_file_text');
        $("#new_file_text" + i).fadeOut();
        $("#new_file_text" + i).addClass('remove_file_text');
        $("#remove_field" + i).fadeOut();
        $("#undo_field" + i).css("visibility", "visible");
        $("#undo_field" + i).fadeIn();
}
function undo_file(i) {
    console.log("undo_file" + i);
        $("#current_file"+i).removeClass('remove_file_text');
        $("#current_file"+i).addClass('current_file_text');
        $("#remove_field"+i).fadeIn();
        $("#undo_field"+i).css("visibility", "hidden");
        $("#undo_field"+i).fadeOut();
        $("#new_file_text"+i).css("display", "none");
}

