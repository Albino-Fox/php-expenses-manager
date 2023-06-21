<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <title>Expenses</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <h2>Your Expenses</h2>
    <button id="delete-selected" class="btn btn-danger">Delete selected</button>
    <table>
        <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>ID</th>
            <th>Category name</th>
            <th>Vendor</th>
            <th>Account</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php foreach ($data['expenses'] as $expense): 
            $category = Category::find($expense->category_id);
        ?>
            <tr>
                <td><input type="checkbox" class="select-expense" data-expense-id="<?= $expense->id ?>"></td>
                <td><?= $expense->id ?></td>                
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="category" data-old-value="<?= $category->name ?>"><?= $category->name ?></td>
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="vendor" data-old-value="<?php if($expense->vendor) echo($expense->vendor->name);?>"><?php if($expense->vendor) echo($expense->vendor->name);?></td>
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="account" data-old-value="<?php if($expense->account) echo($expense->account->name);?>"><?php if($expense->account) echo($expense->account->name);?></td>

                
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="amount" data-old-value="<?= $expense->amount ?>"><?= $expense->amount ?></td>
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="date" data-old-value="<?= $expense->date ?>"><?= $expense->date ?></td>

            </tr>
        <?php endforeach; ?>
    </table>

    <!--SCRIPTS_PLACEHOLDER-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    <script src="/js/dynamic_table.js"></script>

</body>
</html>
