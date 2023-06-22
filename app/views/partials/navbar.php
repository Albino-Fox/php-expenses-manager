<nav class="navbar">
        <ul>
            <li><a href="/home">Home</a></li>
            <li><a href="/expenses/createExpense">Add Expense</a></li>
            <li><a href="/expenses">View Expenses</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
            <?php if(isset($_SESSION['user_id'])) echo('<li>Logged as: ' . $_SESSION['nickname'] . '</li>');?> 
            <?php if(isset($_SESSION['user_id'])) echo('<li><a href="/logout">Logout</a></li>');?>
        </ul>
</nav>