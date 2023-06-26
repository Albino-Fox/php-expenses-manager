
function handleFormSubmission($form) {
    $form.on('submit', function(e) {
      e.preventDefault();

      let path = window.location.pathname;
      let pathArray = path.split('/').filter(Boolean);

      $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            showAlert(response.message, response.status);

            // additional redirect functional
            if (response.status === 'success') {
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
            }

            },
            error: function() {
                showAlert(response.message, response.status);
            }
      });
    });
  }
 
$('form').each(function() {
    handleFormSubmission($(this));
});