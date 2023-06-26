// create a container for the alerts and append it to the body
let $alertContainer = $('<div/>', {
  id: 'alert-container',
  style: 'position: fixed; top: 0; left: 50%; transform: translateX(-50%); width: 20rem; z-index: 9999;'
});
$('body').append($alertContainer);

function showAlert(message, type) {
  if(type != 'success') type = 'danger';
  if(message !== undefined && message != null && message.length != 0){

    let $alert = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert" style="word-wrap: break-word;">
      <strong>${message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`);

    // append alert to alert container
    $('#alert-container').prepend($alert);


    // start a timer to remove this alert
    setTimeout(function() {
        $alert.fadeOut("slow", function(){
          $(this).remove();
        });
      }, 4000); //4 secs
  }
}