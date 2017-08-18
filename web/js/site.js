var select = false;

function file_input() {
    if (!select) {
        $('#tree-jsonfile').click();
    }
}

function change_option(option) {
    if (option == true) {
        select = true;
        $('#file-path-label').closest('a.btn.raised').addClass('disabled');
        $('#files-list > .radiobutton-input').removeClass('disabled');
    } else {
        select = false;
        $('#file-path-label').closest('a.btn.raised').removeClass('disabled');
        $('#files-list > .radiobutton-input').addClass('disabled');
    }
}

$(document).ready(function () {
    var option = $('.radiobutton-group.submit-options input:checked').val();
    change_option(option);

    $('#tree-jsonfile').change(function () {
        var filepath = $(this).val();
        if (filepath) {
            filepath = filepath.replace(/\\/g, '/');
            filepath = filepath.substring(filepath.lastIndexOf('/') + 1);
            $('#file-path-label').html(filepath);
        } else {
            $('#file-path-label').html('JSON file');
        }
    });

    $('.radiobutton-group.submit-options input').change(function () {
        change_option($(this).val());
    });

    $('#files-list > .radiobutton-input input').change(function () {
        $('input#tree-json').val($(this).val());
    });
});