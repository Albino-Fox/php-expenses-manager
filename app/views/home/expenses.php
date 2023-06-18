<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
</head>
<body>
    <h2>Expenses</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Category ID</th>
            <th>Amount</th>
            <th>Created At</th>
        </tr>
        <?php foreach ($data['expenses'] as $expense): ?>
        <tr>
            <td><?= $expense->id ?></td>
            <td><?= $expense->user_id ?></td>
            <td><?= $expense->category_id ?></td>
            <td><?= $expense->amount ?></td>
            <td><?= $expense->created_at ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
