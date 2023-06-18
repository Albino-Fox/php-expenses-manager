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
            <th>Category Name</th>
            <th>Amount</th>
        </tr>
        <?php foreach ($data['expenses'] as $expense): 
            $category = Category::find($expense->category_id);
        ?>
            <tr>
                <td><?= $expense->id ?></td>
                <td><?= $category->name ?></td>
                <td><?= $expense->amount ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
