$(document).ready(function() {
    const endpoints = {
        'category': 'categories',
        'vendor': 'vendors',
        'account': 'accounts'
    };

    let table = $('#expensesTable').DataTable({
        scrollX: true,
        drawCallback: function() {
            let api = this.api();
            let info = api.page.info();
            let start = info.page * info.length;
            
            api.$('td:first-child', {"page": "current"}).each(function(index) {
                $(this).html(start + index + 1);
            });
        },
        columnDefs: [
            { targets: [0, 1, 10], orderable: false, width: '5%', className: 'center-text vertical-center'},
            { targets: [0], width: '5%', className: 'center-text vertical-center'},
            { targets: [10], width: '10%', className: 'center-text vertical-center'},
            {
                "targets": "_all",
                "className": "max-width-200 overflow-handle vertical-center",
                "createdCell": function(td){
                    td.setAttribute('title', $(td).text());
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json'
        }
    });

    function recreateTable(data){
        table.clear().draw();
        for (let i = 0; i < data.length; i++) {
            let categoryName = data[i].category ? data[i].category.name : 'N/A';
            let vendorName = data[i].vendor ? data[i].vendor.name : 'N/A';
            let accountName = data[i].account ? data[i].account.name : 'N/A';
    
            let typeName = '';
            if(data[i].type == 'I'){
                typeName = 'Доход';
            } else if(data[i].type == 'E'){
                typeName = 'Расход';
            }

            table.row.add([
                i+1,
                '<input type="checkbox" class="select-expense" data-expense-id="' + data[i].id + '">',
                data[i].id,
                categoryName,
                vendorName,
                accountName,
                data[i].amount,
                typeName,
                data[i].date,
                data[i].comment,
                '<button type="button" class="btn btn-primary edit-expense" data-expense-id="' + data[i].id + '"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger delete-expense" data-expense-id="' + data[i].id + '"><i class="fas fa-trash"></i></button>'
            ]).draw();
        }
    }

    $.ajax({ 
        url: '/expenses/getExpenses',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            recreateTable(data);
            updateAnalysis();
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

        if(rowData[7] == 'Доход'){
            $('#editExpenseType').val('I');
        } else if(rowData[7] == 'Расход'){
            $('#editExpenseType').val('E');
        }
        $('#editExpenseDate').val(rowData[8]);

        $('#editExpenseComment').val(rowData[9]);

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
                date: $('#editExpenseDate').val(),
                comment: $('#editExpenseComment').val()
            },
            success: function() {
                // refresh the table
                $.ajax({
                    url: '/expenses/getExpenses',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        recreateTable(data);
                        updateAnalysis();
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
                // response = JSON.parse(response);
                if (response.status === 'success') {
                    // remove the row from the table
                    table.row(deleteButton.parents('tr')).remove().draw(false);  // use preserved context here
                    updateAnalysis();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    });

    $('#saveChanges').click(function() {
        $('#editExpenseForm').submit();
    });

    $('#select-all').change(function() {
        let isChecked = $(this).prop('checked');
        
        table.rows().nodes().to$().each(function() {
            if(isChecked) {
                $(this).find('input.select-expense').prop('checked', true);
                $(this).addClass('selected');
            } else {
                $(this).find('input.select-expense').prop('checked', false);
                $(this).removeClass('selected');
            }
        });
    });

    $('#expensesTable tbody').on('click', 'tr td:nth-child(2) input.select-expense', function (e) {
        e.stopPropagation(); // Prevent event propagation to the row
        $(this).closest('tr').toggleClass('selected');
    });

    $('#delete-selected').click(function() {
        let selectedIds = $.map(table.rows('.selected').nodes().to$(), function (item) {
            return $(item).find('input.select-expense').data('expense-id');
        });        

        if (selectedIds.length > 0) {
            if (confirm('Are you sure you want to delete the selected expenses?')) {
                $.ajax({
                    url: '/expenses/deleteSelected',
                    type: 'POST',
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        // response = JSON.parse(response);
                        if (response.status === 'success') {
                            // remove the rows from the table
                            $('#select-all').prop('checked', false);
                            table.rows('.selected').remove().draw(false);
                            updateAnalysis();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Failed to delete expenses');
                    }
                });
            }
        } else {
            alert('Please select at least one expense to delete');
        }
    });


    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});

