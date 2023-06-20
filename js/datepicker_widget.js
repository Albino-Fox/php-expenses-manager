$(document).ready(function() {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate: new Date(), // Optional: Set the minimum selectable date to today
    endDate: '+30d' // Optional: Set the maximum selectable date to 30 days from today
  });
});