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

    $("#document_successor_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("div#revoked_by .dropdown-menu li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        console.log("document_successor_input");
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

$("div#revoked_by .dropdown-menu li").click(function(){
    console.log("dropdown-menu revoked_by");
    $(this).parents(".dropdown ").find('#dropdownRevokedBy').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown ").find('#dropdownRevokedBy').val($(this).data('value'));

});

$("div#tags_ul .dropdown-menu li").click(function(){
    console.log("dropdown-menu published_at");
    $(this).parents(".dropdown ").find('#tags').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown ").find('#tags').val($(this).data('value'));
});

