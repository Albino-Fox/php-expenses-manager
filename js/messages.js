function handleFormSubmission($form) {
    var messageId = '#' + $form.data('response');

    if (!$(messageId).length) {
        $form.after('<div id="' + messageId.replace('#', '') + '"></div>');
    }

    $form.on('submit', function(e) {
        e.preventDefault();

        var path = window.location.pathname;

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    // Display success message
                    $(messageId).text(response.message).removeClass('error').addClass('success');

                    // Additional redirect functional
                    console.log(path);
                    //maybe use switch case?
                    if (path === '/login') { //as on login page no other 'success' messages
                        window.location.href = '/home';
                    } else if (path === '/register'){
                        window.location.href = '/login';
                    }
                } else {
                    // Display error message
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
