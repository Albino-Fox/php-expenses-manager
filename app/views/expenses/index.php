<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
</head>
<body>
    <h2>Your Expenses</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Category name</th>
            <th>Vendor</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php foreach ($data['expenses'] as $expense): 
            $category = Category::find($expense->category_id);
        ?>
            <tr>
                <td><?= $expense->id ?></td>
                <td><?= $category->name ?></td>
                <td><?php if($expense->vendor) echo($expense->vendor->name); ?></td>
                <td><?= $expense->amount ?></td>
                <td><?= $expense->date ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    
</body>
</html>
