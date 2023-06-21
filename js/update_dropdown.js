function updateDropdown(dropdownId, url) {
    var needsUpdate = true;

    $(dropdownId).on('focus', function() {
        if (needsUpdate) {
            // Save the currently selected value
            var currentValue = $(dropdownId).val();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // Clear the current options
                    $(dropdownId).empty();

                    // Parse the response JSON
                    var items = JSON.parse(response);

                    $(dropdownId).append('<option value=""></option>');

                    // Add each item as an option
                    items.forEach(function(item) {
                        $(dropdownId).append('<option value="' + item.name + '">' + item.name + '</option>');
                    });

                    // If the previously selected value is in the new options, reselect it
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
