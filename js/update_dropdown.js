function updateDropdown(dropdownId, url) {
    let needsUpdate = true;

    $(dropdownId).on('focus', function() {
        if (needsUpdate) {
            // save the currently selected value
            let currentValue = $(dropdownId).val();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $(dropdownId).empty();

                    let items = JSON.parse(response);

                    $(dropdownId).append('<option value=""></option>');

                    items.forEach(function(item) {
                        $(dropdownId).append('<option value="' + item.name + '">' + item.name + '</option>');
                    });

                    if ($(dropdownId + ' option[value="' + currentValue + '"]').length > 0) {
                        $(dropdownId).val(currentValue);
                    }

                    needsUpdate = false;
                },
                error: function() {
                    console.error('An error occurred while trying to fetch the data.');
                }
            });
        }
    }).on('blur', function() {
        needsUpdate = true;
    });
}


updateDropdown('#expense_category_name', '/expenses/getCategories');
updateDropdown('#expense_vendor_name', '/expenses/getVendors');
updateDropdown('#expense_account_name', '/expenses/getAccounts');
