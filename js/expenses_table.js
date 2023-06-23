$(document).ready(function() {
    let table = $('#expensesTable').DataTable();

    function recreateTable(data){
        table.clear().draw();
        for (let i = 0; i < data.length; i++) {
            let categoryName = data[i].category ? data[i].category.name : 'N/A';
            let vendorName = data[i].vendor ? data[i].vendor.name : 'N/A';
            let accountName = data[i].account ? data[i].account.name : 'N/A';
    
            table.row.add([
                i+1,
                '<input type="checkbox" class="select-expense" data-expense-id="' + data[i].id + '">',
                data[i].id,
                categoryName,
                vendorName,
                accountName,
                data[i].amount,
                data[i].type,
                data[i].date,
                '<button type="button" class="btn btn-primary edit-expense" data-expense-id="' + data[i].id + '">Edit</button><button type="button" class="btn btn-danger delete-expense" data-expense-id="' + data[i].id + '">Delete</button>'
            ]).draw();
        }
    }

    $.ajax({
        url: '/expenses/getExpenses',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            recreateTable(data);
        }        
    });



    // wire up the edit buttons
    $('#expensesTable').on('click', '.edit-expense', function() {
        let rowData = table.row($(this).parents('tr')).data();
        
        // populate the form with the current values
        $('#editExpenseCategory').val(rowData[3]);
        $('#editExpenseVendor').val(rowData[4]);
        $('#editExpenseAccount').val(rowData[5]);
        $('#editExpenseAmount').val(rowData[6]);
        $('#editExpenseType').val(rowData[7]);
        $('#editExpenseDate').val(rowData[8]);

        // store the id of the expense being edited
        $('#editExpenseForm').data('id', rowData[2]);

        // show the modal
        $('#editExpenseModal').modal('show');
    });



    // handle the form submission
    $('#editExpenseForm').submit(function(e) {
        e.preventDefault();

        // get the id of the expense being edited
        let expenseId = $(this).data('id');

        $.ajax({
            url: '/expenses/updateExpense',
            type: 'POST',
            data: {
                id: expenseId,
                category: $('#editExpenseCategory').val(),
                vendor: $('#editExpenseVendor').val(),
                account: $('#editExpenseAccount').val(),
                amount: $('#editExpenseAmount').val(),
                type: $('#editExpenseType').val(),
                date: $('#editExpenseDate').val()
            },
            success: function() {
                // refresh the table
                $.ajax({
                    url: '/expenses/getExpenses',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        recreateTable(data);
                    }  
                });

                // hide the modal
                $('#editExpenseModal').modal('hide');
            }
        });
    });

    $('#expensesTable').on('click', '.delete-expense', function() {
        let expenseId = $(this).data('expense-id');
        let deleteButton = $(this);  // Preserve the context here
    
        $.ajax({
            url: '/expenses/deleteExpense',
            type: 'POST',
            data: {
                id: expenseId
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    // remove the row from the table
                    table.row(deleteButton.parents('tr')).remove().draw();  // Use preserved context here
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    });
    

    $('#saveChanges').click(function() {
        $('#editExpenseForm').submit();
    });
});

