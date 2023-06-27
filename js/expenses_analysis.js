$(document).ready(function() {
    $.ajax({
        url: '/expenses/getExpensesAmountStats',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Income', 'Expenses'],
                    datasets: [{
                        label: 'Amount',
                        data: [data.income, data.expenses],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$(document).ready(function() {
    $.ajax({
        url: '/expenses/getCategoryDistribution',  // Update with the correct URL
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var labels = [];
            var dataset = [];
            for (var i = 0; i < data.length; i++) {
                labels.push(data[i].category_id);  // Assuming category_id is a meaningful identifier to the user. If not, you'll need to fetch the category name.
                dataset.push(data[i].total);
            }

            var ctx = document.getElementById('categoryDistributionChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Amount',
                        data: dataset,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
});


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
