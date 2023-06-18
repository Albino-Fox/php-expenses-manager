<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Home</title>
</head>
<body>
   <nav>
       <ul>
           <li><a href="/home/index">Home</a></li>
           <li><a href="/home/createExpense">Create Expense</a></li>
           <li><a href="/register/index">Register</a></li>
           <li><a href="/home/viewExpenses">View Expenses</a></li>
       </ul>
   </nav>
   <p>Hi, <?= $data['name']?>!</p>
</body>
</html>
