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


/*$(document).ready(function() {
    var max_fields      = 6; //maximum input boxes allowed
    var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var input

    var x = 1; //initial text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append
            ('<div class="form-inline px-2 border p-2">' +
                '<a href="#" class="remove_field px-2">' +
                '<i class="far fa-trash-alt" style="color: black" aria-hidden="true"></i>' +
                '</a>' +
                '<input class="input" type="file" name="files[]" id="file">' +
                '</div>');
            var input = document.getElementById('file' );
            var infoArea = document.getElementById( 'files' );
            }

        input.addEventListener( 'change', showFileName2 );
        function showFileName2( event ) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = fileName;
            console.log(fileName);
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })


});*/

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


$(document).ready(function() {

});
