<nav>
        <ul>
            <li><a href="/home">Home</a></li>
            <li><a href="/expenses/createExpense">Add Expense</a></li>
            <li><a href="/expenses">View Expenses</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
            </br> <!-- <- rewrite later -->
            <?php if(isset($_SESSION['user_id'])) echo('Logged in: ' . $_SESSION['nickname']);?> 
            <?php if(isset($_SESSION['user_id'])) echo('<li><a href="/logout">Logout</a></li>');?>
        </ul>
</nav>