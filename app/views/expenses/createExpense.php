<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Expense</title>
</head>
<body>
    <h2>Create Expense</h2>
    <form action="/expenses/createExpense" method="post">
        <input type="text" name="category_name" placeholder="Category Name">
        <input type="number" name="amount" placeholder="Amount">
        <button type="submit">Create Expense</button>
    </form>
</body>
</html>