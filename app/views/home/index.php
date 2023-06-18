<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <p>Hi, <?= $data['name']?>!</p>

    <h2>Create a Category</h2>
    <form action="home/createCategory" method="post">
        <input type="text" name="name" placeholder="Category Name">
        <input type="hidden" name="user_id" value="1"> <!-- Hardcoded user ID -->
        <button type="submit">Create Category</button>
    </form>

    <h2>Create an Expense</h2>
    <form action="home/createExpense" method="post">
        <input type="text" name="amount" placeholder="Amount">
        <input type="text" name="category_id" placeholder="Category ID">
        <input type="hidden" name="user_id" value="1"> <!-- Hardcoded user ID -->
        <button type="submit">Create Expense</button>
    </form>
</body>
</html>
