<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
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
        <label for="date">Date:</label>
        <input type="text" id="datepicker" name="selectedDate" value="<?= date('Y-m-d'); ?>">
        <input type="submit" value="Create Expense">
    </form>

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    

</body>
</html>
