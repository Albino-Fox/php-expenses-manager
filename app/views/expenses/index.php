<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <h2>Your Expenses</h2>
    <table>
        <tr>
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
                <td><?= $expense->id ?></td>                
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="category"><?= $category->name ?></td>
                <td><?php if($expense->vendor) echo($expense->vendor->name); else echo('-');?></td>
                <td><?php if($expense->account) echo($expense->account->name); else echo('-');?></td>
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="amount" data-old-value="<?= $expense->amount ?>"><?= $expense->amount ?></td>
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="date" data-old-value="<?= $expense->date ?>"><?= $expense->date ?></td>

            </tr>
        <?php endforeach; ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="/js/dynamic_table.js"></script>

</body>
</html>
