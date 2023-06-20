<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add expenses</title>
</head>
<body>
    <!-- Category Form -->
    <form method="POST" action="/expenses/createCategory">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name">
        <input type="submit" value="Create Category">
    </form>

    <!-- Vendor Form -->
    <form method="POST" action="/expenses/createVendor">
        <label for="vendor_name">Vendor Name:</label>
        <input type="text" id="vendor_name" name="vendor_name">
        <input type="submit" value="Create Vendor">
    </form>

    </br>

    <!-- Expense Form -->
    <form method="POST" action="/expenses/createExpense">
        <label for="category_name">Category:</label>
        <select name="category_name" id="category_name">
            <?php foreach($data['categories'] as $category) { ?>
                <option value="<?= $category->name; ?>"><?= $category->name; ?></option>
            <?php } ?>
        </select>
        <label for="vendor_name">Vendor:</label>
        <select name="vendor_name" id="vendor_name">
            <option value=""></option>
            <?php foreach($data['vendors'] as $vendor) { ?>
                <option value="<?= $vendor->name; ?>"><?= $vendor->name; ?></option>
            <?php } ?>
        </select>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount">
        <input type="submit" value="Create Expense">
    </form>
</body>
</html>
