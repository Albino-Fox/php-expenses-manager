function handleFormSubmission($form) {
    let messageId = '#' + $form.data('response');
    let timerId; // timer ID for clearTimeout
  
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
            switch (pathArray[0]) {
              case 'login':
                // as on login page no other 'success' messages
                window.location.href = '/home';
                break;
              case 'register':
                // as on login page no other 'success' messages
                window.location.href = '/login';
                break;
            }
  
            // reset the timer if a new message appears
            clearTimeout(timerId);
            timerId = setTimeout(function() {
              $(messageId).text('').removeClass('success');
            }, 3000);
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
  