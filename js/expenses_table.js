$(document).ready(function() {
    const endpoints = {
        'category': 'categories',
        'vendor': 'vendors',
        'account': 'accounts'
    };

    let table = $('#expensesTable').DataTable({
        columnDefs: [
            { targets: [1, 9], orderable: false }
        ]
    });

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

    function populateSelect(type, currentText) {
        // fetch the data from the server
        $.ajax({
            url: `/expenses/get${capitalize(endpoints[type])}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // populate the select list
                let selectElement = $(`#editExpense${capitalize(type)}`);
                selectElement.empty();
                if (type === 'vendor' || type === 'account') {
                    selectElement.append($('<option>').val('').text(''));
                }
                $.each(data, function (i, item) {
                    selectElement.append($('<option>').val(item.id).text(item.name));
                });
    
                // set the selected option
                selectElement.find(`option:contains(${currentText})`).attr('selected', 'selected');
            }
        });
    }
    


    // wire up the edit buttons
    $('#expensesTable').on('click', '.edit-expense', function() {
        let rowData = table.row($(this).parents('tr')).data();
        
        // store the id of the expense being edited
        $('#editExpenseForm').data('id', rowData[2]);

        // show the modal
        $('#editExpenseModal').modal('show');

        // populate the form with the current values
        $('#editExpenseAmount').val(rowData[6]);
        $('#editExpenseType').val(rowData[7]);
        $('#editExpenseDate').val(rowData[8]);

        // populate and auto-select the category, vendor, and account
        populateSelect('category', rowData[3]);
        populateSelect('vendor', rowData[4]);
        populateSelect('account', rowData[5]);

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
                category: $('#editExpenseCategory option:selected').text(),
                vendor: $('#editExpenseVendor option:selected').text(),
                account: $('#editExpenseAccount option:selected').text(),
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

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});

