window.toggleValidation = function(field, error) {
    if (error) {
        $(`#${field}`).addClass('is-invalid')
            .siblings('p')
            .addClass('invalid-feedback')
            .html(error);
    } else {
        $(`#${field}`).removeClass('is-invalid')
            .siblings('p')
            .removeClass('invalid-feedback')
            .html('');
    }
}