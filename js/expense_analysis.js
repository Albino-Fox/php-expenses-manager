$(document).ready(function() {
    window.updateExpenseAnalysis = function() {
        let totalIncome = 0;
        let totalExpenses = 0;
    
        $('td[data-field="amount"]').each(function() {
            if ($(this).data('editing')) {
                return true;  // skip this iteration if the cell is being edited
            }
            const amountText = $(this).text().trim();
            const amount = parseFloat(amountText);
            const type = $(this).siblings().filter('[data-field="type"]').data('old-value');
    
            // check if it's a valid number before adding to the totals
            if (!isNaN(amount) && isFinite(amount) && amountText !== "") {
                if (type === 'I') {
                    totalIncome += amount;
                } else {
                    totalExpenses += amount;
                }
            }
        });
    
        const difference = totalIncome - totalExpenses;
    
        $('#total-income').text(totalIncome.toFixed(2));
        $('#total-expenses').text(totalExpenses.toFixed(2));
        $('#difference').text(difference.toFixed(2));
    };
    
    updateExpenseAnalysis();
});
