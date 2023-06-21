$(document).ready(function() {
    $('.editable').click(function() {
        var td = $(this);
        var oldValue = td.data('old-value');
        var expenseId = td.data('expense-id');
        var field = td.data('field');
        td.text('');
        var input = $('<input type="text">');
        input.val(oldValue);
        td.append(input);
        input.focus();
        input.blur(function() {
            var newValue = input.val();
            if (newValue === oldValue) {
                td.text(oldValue);
            } else {
                $.post('/expenses/update', {
                    expense_id: expenseId,
                    field: field,
                    value: newValue
                })
                .done(function() {
                    td.text(newValue);
                })
                .fail(function() {
                    td.text(oldValue);
                });
            }
        });
    });
});
