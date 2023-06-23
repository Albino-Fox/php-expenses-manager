<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Expenses</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <h2>Your Expenses</h2>
    <button id="delete-selected" class="btn btn-danger">Delete selected</button>
    <!-- <table>
        <tr>
            <th>No.</th>
            <th><input type="checkbox" id="select-all"></th>
            <th>ID</th>
            <th>Category name</th>
            <th>Vendor</th>
            <th>Account</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
        <?php $counter = 0; 
            foreach ($data['expenses'] as $expense): 
            $counter++;
            $category = Category::find($expense->category_id);
        ?>
            <tr>
                <td class="expense-number"><?=$counter?></td>
                <td><input type="checkbox" class="select-expense" data-expense-id="<?= $expense->id ?>"></td>
                <td><?= $expense->id ?></td>                
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="category" data-old-value="<?= $category->name ?>"><?= $category->name ?></td>
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="vendor" data-old-value="<?php if($expense->vendor) echo($expense->vendor->name);?>"><?php if($expense->vendor) echo($expense->vendor->name);?></td>
                <td class="" data-expense-id="<?= $expense->id ?>" data-field="account" data-old-value="<?php if($expense->account) echo($expense->account->name);?>"><?php if($expense->account) echo($expense->account->name);?></td>
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="amount" data-old-value="<?= $expense->amount ?>"><?= $expense->amount ?></td>
                <td class="" data-expense-id="<?= $expense->type ?>" data-field="type" data-old-value="<?= $expense->type ?>"><?= $expense->type ?></td>
                <td class="editable" data-expense-id="<?= $expense->id ?>" data-field="date" data-old-value="<?= $expense->date ?>"><?= $expense->date ?></td>
            </tr>
        <?php endforeach;
            $counter = 1 ?>
    </table> -->

    <table id="expensesTable" class="display">
        <thead>
            <tr>
                <th>No.</th>
                <th><input type="checkbox" id="select-all"></th>
                <th>ID</th>
                <th>Category name</th>
                <th>Vendor</th>
                <th>Account</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be inserted here dynamically -->
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="editExpenseModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Expense</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editExpenseForm">
                <div class="form-group">
                    <label for="editExpenseCategory">Category</label>
                    <input type="text" class="form-control" id="editExpenseCategory" name="category">
                </div>
                <div class="form-group">
                    <label for="editExpenseVendor">Vendor</label>
                    <input type="text" class="form-control" id="editExpenseVendor" name="vendor">
                </div>
                <div class="form-group">
                    <label for="editExpenseAccount">Account</label>
                    <input type="text" class="form-control" id="editExpenseAccount" name="account">
                </div>
                <div class="form-group">
                    <label for="editExpenseAmount">Amount</label>
                    <input type="text" class="form-control" id="editExpenseAmount" name="amount">
                </div>
                <div class="form-group">
                    <label for="editExpenseType">Type</label>
                    <input type="text" class="form-control" id="editExpenseType" name="type">
                </div>
                <div class="form-group">
                    <label for="editExpenseDate">Date</label>
                    <input type="text" class="form-control" id="editExpenseDate" name="date">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    <div id="analysis">
        <h3>Analysis</h3>
        <p>Total income: <span id="total-income"></span></p>
        <p>Total expenses: <span id="total-expenses"></span></p>
        <p>Budget: <span id="difference"></span></p>
    </div>
    
    <!-- <div id="analysis-container">
        <h3>Analysis</h3>
        <p>Income Amount: <?php echo $data['incomeAmount']; ?></p>
        <p>Expense Amount: <?php echo $data['expenseAmount']; ?></p>
        <p>Difference: <?php echo $data['difference']; ?></p>
    </div> -->


    <!--SCRIPTS_PLACEHOLDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    <script src="/js/expense_analysis.js"></script>
    <script src="/js/dynamic_table.js"></script>
    <script src="/js/expenses_table.js"></script>


</body>
</html>
