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
        <label for="category_name">Category:</label>
        <select name="category_name" id="category_name">
            <?php foreach($data['categories'] as $category) { ?>
                <option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
            <?php } ?>
        </select>
        <input type="number" name="amount" placeholder="Amount">
        <button type="submit">Create Expense</button>
    </form>
</body>
</html>