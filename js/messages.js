function handleFormSubmission($form) {
    let messageId = '#' + $form.data('response');

    if (!$(messageId).length) {
        $form.after('<div id="' + messageId.replace('#', '') + '"></div>');
    }

    $form.on('submit', function(e) {
        e.preventDefault();

        let path = window.location.pathname;
        let pathArray = path.split('/').filter(Boolean);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    // display success message
                    $(messageId).text(response.message).removeClass('error').addClass('success');

                    // additional redirect functional
                    //maybe use switch case?
                    if (pathArray[0] === 'login') { //as on login page no other 'success' messages
                        window.location.href = '/home';
                    } else if (pathArray[0] === 'register'){  //as on login page no other 'success' messages
                        window.location.href = '/login';
                    }
                } else {
                    // display error message
                    $(messageId).text(response.message).removeClass('success').addClass('error');
                }
            },
            error: function() {
                $(messageId).text('An error occurred while trying to submit the form.').removeClass('success').addClass('error');
            }
        });
    });
}

$('form').each(function() {
    handleFormSubmission($(this));
});