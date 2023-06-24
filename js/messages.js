// create a container for the alerts and append it to the body
let $alertContainer = $('<div/>', {
  id: 'alert-container',
  style: 'position: fixed; top: 0; left: 50%; transform: translateX(-50%); width: 20rem; z-index: 9999;'
});
$('body').append($alertContainer);

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
          let alertType = response.status === 'success' ? 'success' : 'danger';
          let alertMessage = response.message;

          // create bootstrap alert
          let $alert = $(`<div class="alert alert-${alertType} alert-dismissible fade show" role="alert" style="word-wrap: break-word;">
            <strong>${alertMessage}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`);

          // append alert to alert container
          $('#alert-container').append($alert);

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

          // start a timer to remove this alert
          setTimeout(function() {
            $alert.fadeOut("slow", function(){
              $(this).remove();
            });
          }, 3000);
        },
        error: function() {
          // create bootstrap alert
          let $alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="word-wrap: break-word;">
            <strong>An error occurred while trying to submit the form.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`);

          // Append alert to alert container
          $('#alert-container').append($alert);
        }
      });
    });
  }

  $('form').each(function() {
    handleFormSubmission($(this));
  });

  $('.btn').each(function() {
    handleFormSubmission($(this));
  });
