$(document).ready(function() {
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
                    "className": "max-width-200 overflow-handle vertical-center"
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
                        table.row.add([
                            '<input type="checkbox" class="select-' + type + '" value="' + data[i].id + '">',
                            data[i].name,
                            '<button type="button" class="btn btn-primary edit-' + type + '" data-id="' + data[i].id + '" data-name="' + data[i].name + '">' + '<i class="fas fa-pencil-alt"></i>' + '</button>' +
                            '<button type="button" class="btn btn-danger delete-' + type + '" data-id="' + data[i].id + '">' + '<i class="fas fa-trash"></i>' + '</button>'
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
                success: function() {
                    // refresh the table
                    $('#' + type + 'Modal').trigger('show.bs.modal');
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
            $('#editType').val(type);
        
            // show the edit modal
            $('#editModal').modal('show');
        });
        
        $('#saveEdit').click(function() {
            let itemId = $('#editId').val();
            let itemName = $('#editName').val();
            let type = $('#editType').val();
            let plural = pluralMap[type];
        
            $.ajax({
                url: '/expenses/edit' + capitalizeFirstLetter(plural),
                type: 'POST',
                data: { id: itemId, name: itemName },
                success: function() {
                    // refresh the table
                    $('#' + type + 'Modal').trigger('show.bs.modal');
        
                    // close the edit modal
                    $('#editModal').modal('hide');
                }
            });
        });        

        // handle the delete selected items button
        $('#deleteSelected' + capitalizeFirstLetter(plural)).click(function() {
            let selectedItems = $('.select-' + type + ':checked').map(function() {
                return $(this).val();
            }).get();
            if(selectedItems){
                $.ajax({
                    url: '/expenses/delete' + capitalizeFirstLetter(plural),
                    type: 'POST',
                    data: { [plural]: selectedItems },
                    success: function() {
                        // refresh the table
                        $('#' + type + 'Modal').trigger('show.bs.modal');
                    }
                });
            }
        });
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
