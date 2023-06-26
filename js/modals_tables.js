$(document).ready(function() {
    let currentType; 


    let pluralMap = {
        'category': 'categories',
        'vendor': 'vendors',
        'account': 'accounts'
    };

    setupModal('category');
    setupModal('vendor');
    setupModal('account');

    function setupModal(type) {
        let plural = pluralMap[type];
        let table = $('#' + type + 'Table').DataTable({
            autoWidth: false,
            columnDefs: [
                { targets: [0, 2], orderable: false, "className": "center-text vertical-center"},
                {
                    "targets": "_all",
                    "className": "max-width-200 overflow-handle vertical-center",
                    "createdCell": function(td){
                        td.setAttribute('title', $(td).text());
                    }
                }
            ],
            columns: [
                { width: "5%" }, // width for the first column
                {}, // width for the second column
                { width: "10%" }  // width for the third column
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json'
            }
        });
    

        $('#' + type + 'Modal').on('show.bs.modal', function (event) {
            $.ajax({
                url: '/expenses/get' + capitalizeFirstLetter(plural),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // clear the table before populating it
                    table.clear().draw();
                
                    // add each item to the table
                    for (let i = 0; i < data.length; i++) {
                        let deleteButton = data[i].is_used 
                            ? '<button type="button" class="btn btn-warning" disabled><i class="fas fa-exclamation-triangle"></i></button>'  // display warning sign if item is used
                            : '<button type="button" class="btn btn-danger delete-' + type + '" data-id="' + data[i].id + '">' + '<i class="fas fa-trash"></i>' + '</button>';  // otherwise, display delete button

                        table.row.add([
                            '<input type="checkbox" class="select-' + type + '" value="' + data[i].id + '">',
                            data[i].name,
                            '<button type="button" class="btn btn-primary edit-' + type + '" data-id="' + data[i].id + '" data-name="' + data[i].name + '">' + '<i class="fas fa-pencil-alt"></i>' + '</button>' +
                            deleteButton
                        ]).draw();
                    }
                }
            });
        });

        // wire up the delete buttons
        $('#' + type + 'Table').on('click', '.delete-' + type, function() {
            let itemId = $(this).data('id');

            $.ajax({
                url: '/expenses/delete' + capitalizeFirstLetter(plural),
                type: 'POST',
                data: { [plural]: [itemId] },
                success: function(response) {
                    showAlert(response.message, response.status);
                    // refresh the table
                    $('#' + type + 'Modal').trigger('show.bs.modal');
                },
                error: function(response) {
                    showAlert(response.message, response.status);
                }
            });
        });

        // wire up the edit buttons
        $('#' + type + 'Table').on('click', '.edit-' + type, function() {
            let itemId = $(this).data('id');
            let itemName = $(this).data('name');
        
            // populate the edit modal with the current name and ID
            $('#editName').val(itemName);
            $('#editId').val(itemId);
        
            currentType = type; // set currentType when the edit button is clicked
        
            // show the edit modal
            $('#editModal').modal('show');
        });
        
        $('#saveEdit').off('click').on('click', function() {
            let itemId = $('#editId').val();
            let itemName = $('#editName').val();
            let type = currentType; // use currentType instead of $('#editType').val()
            let plural = pluralMap[type];

            $.ajax({
                url: '/expenses/edit' + capitalizeFirstLetter(plural),
                type: 'POST',
                data: { id: itemId, name: itemName },
                success: function(response) {
                    showAlert(response.message, response.status);
                    
                    // refresh the table
                    $('#' + type + 'Modal').trigger('show.bs.modal');
                    
                    // close the edit modal
                    $('#editModal').modal('hide');
                },
                error: function(response) {
                    showAlert(response.message, response.status);
                }
            });
        });     

        $('#' + type + 'Table tbody').on('click', 'tr td:nth-child(1) input.select-' + type + '', function (e) {
            e.stopPropagation(); // prevent event propagation to the row
            $(this).closest('tr').toggleClass('selected-row');
        });

        // handle the delete selected items button
        $('#deleteSelected' + capitalizeFirstLetter(plural)).click(function() {
            let selectedItems = $.map(table.rows('.selected-row').nodes().to$(), function (item) {
                return $(item).find('input.select-' + type + '').val();
            });
            if(selectedItems){
                $.ajax({
                    url: '/expenses/delete' + capitalizeFirstLetter(plural),
                    type: 'POST',
                    data: { [plural]: selectedItems },
                    success: function(response) {
                        showAlert(response.message, response.status);
                        // refresh the table
                        $('#' + type + 'Modal').trigger('show.bs.modal');
                    },
                    error: function(response) {
                        showAlert(response.message, response.status);
                    }
                });
            }
        });
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
