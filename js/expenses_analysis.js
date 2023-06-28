function updateAnalysis() {
    $.ajax({
        url: '/expenses/getExpensesAmountStats',
        type: 'GET',
        data: 'json',
        success: function(data) {
            // calculate total income and total expenses
            data = JSON.parse(data);
            let totalIncome = data.income;
            let totalExpenses = data.expenses;

            let totalDifference = totalIncome-totalExpenses;

            // display the totals on the page
            $('#totalIncome').text(totalIncome.toFixed(2));
            $('#totalExpenses').text(totalExpenses.toFixed(2));
            $('#totalDifference').text(totalDifference.toFixed(2));
        }
    });
}
