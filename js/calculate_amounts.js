$(document).ready(function() {
    $('.editable').each(function() {
        // add a flag to each editable cell indicating whether it's being edited
        $(this).data('editing', false);
    });

    // ... Existing code ...

    // Analyze expenses amounts
    var expenses = $('.editable[data-field="amount"]').map(function() {
        return parseFloat($(this).text());
    }).get();

    var totalExpenses = expenses.reduce(function(a, b) {
        return a + b;
    }, 0);

    var averageExpense = totalExpenses / expenses.length;
    averageExpense = averageExpense.toFixed(2);

    var maxExpense = Math.max(...expenses).toFixed(2);

    // Display analysis results
    var analysisHTML = 
        '<p>Total Expenses: ' + totalExpenses.toFixed(2) + '</p>' +
        '<p>Average Expense: ' + averageExpense + '</p>' +
        '<p>Max Expense: ' + maxExpense + '</p>';

    $('#analysis-container').html(analysisHTML);
});
