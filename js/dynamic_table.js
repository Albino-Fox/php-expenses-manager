$(document).ready(function() {
    $('.editable').each(function() {
        // add a flag to each editable cell indicating whether it's being edited
        $(this).data('editing', false);
    });

    $('.editable').click(function() {
        let td = $(this);
        let oldValue = td.data('old-value');
        let expenseId = td.data('expense-id');
        let field = td.data('field');

        // if the cell is being edited, don't trigger the click event
        if (td.data('editing')) {
            return;
        }

        td.data('editing', true);  // set the editing flag to true
        td.text('');
        let input = $('<input type="text">');
        if(field == 'date'){
            input = $('<input type="text" id="datepicker" name="selected_date">');
        }
        input.val(oldValue);
        td.append(input);
        input.focus();
        input.blur(function() {
            td.data('editing', false);  // clear the editing flag
            let newValue = input.val();
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
                    td.data('old-value', newValue);
                })
                .fail(function() {
                    td.text(oldValue);
                });
            }
        });
    });

    $('#select-all').change(function() {
        $('.select-expense').prop('checked', $(this).prop('checked'));
    });

    $('#delete-selected').click(function() {
        let selectedIds = [];
        $('.select-expense:checked').each(function() {
            selectedIds.push($(this).data('expense-id'));
        });

        if (selectedIds.length > 0) {
            if (confirm('Are you sure you want to delete the selected expenses?')) { // rewrite in future?
                $.post('/expenses/deleteSelected', {
                    ids: selectedIds
                })
                .done(function() {
                    location.reload();
                })
                .fail(function() {
                    alert('Failed to delete expenses'); // rewrite in future?
                });
            }
        } else {
            alert('Please select at least one expense to delete'); // rewrite in future?
        }
    });
});

