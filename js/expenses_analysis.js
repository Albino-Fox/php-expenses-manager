function updateAnalysis() {
    // get the selected start and end dates
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();

    // fetch the data from the server
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
            $('#totalIncome').text(totalIncome);
            $('#totalExpenses').text(totalExpenses);
            $('#totalDifference').text(totalDifference);
        }
    });
}
