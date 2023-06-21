$('#expense_form').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.status === 'success') {
                // Display success message
                $('#message').text(response.message).removeClass('error').addClass('success');
            } else {
                // Display error message
                $('#message').text(response.message).removeClass('success').addClass('error');
            }
        },
        error: function() {
            // Handle any errors that occurred while trying to send the request
            $('#message').text('An error occurred while trying to create the expense. Please try again.').removeClass('success').addClass('error');
        }
    });
});
