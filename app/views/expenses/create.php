<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Add expenses</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->

    <!-- Category Form -->
    <form id="create_category_form" method="POST" action="/expenses/createCategory" data-response="categoryMsg">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name">
        <input type="submit" value="Create Category">
    </form>

    <!-- Vendor Form -->
    <form id="create_vendor_form" method="POST" action="/expenses/createVendor" data-response="vendorMsg">
        <label for="vendor_name">Vendor Name:</label>
        <input type="text" id="vendor_name" name="vendor_name" >
        <input type="submit" value="Create Vendor">
    </form>

    <form id="create_account_form" method="POST" action="/expenses/createAccount" data-response="accountMsg">
        <label for="account_name">Account Name:</label>
        <input type="text" id="account_name" name="account_name">
        <input type="submit" value="Create Account">
    </form>

    </br>

    <button type="button" class="" data-bs-toggle="modal" data-bs-target="#categoryModal">
        View Categories
    </button>

    <button type="button" class="" data-bs-toggle="modal" data-bs-target="#vendorModal">
        View Vendors
    </button>

    <button type="button" class="" data-bs-toggle="modal" data-bs-target="#accountModal">
        View Accounts
    </button>

    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="categoryModalLabel">Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="categoryTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedCategories">Delete Selected</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Vendor Modal -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="vendorModalLabel">Vendors</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="vendorTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedVendors">Delete Selected</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="accountModalLabel">Accounts</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="accountTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedAccounts">Delete Selected</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="editName" class="form-control">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="editType">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveEdit">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    </br>
    </br>

    <!-- Expense Form -->
    <form id="expense_form" method="POST" action="/expenses/createExpense" data-response="expenseMsg">
        <label for="expense_category_name">Category:</label>
        <select name="category_name" id="expense_category_name">
            <option value=""></option>
            <?php foreach($data['categories'] as $category) { ?>
                <option value="<?= $category->name; ?>"><?= $category->name; ?></option>
            <?php } ?>
        </select>
        <label for="expense_type_name">Type:</label>
        <select name="expense_type" id="expense_type_name">
            <option value="E">Expense</option>
            <option value="I">Income</option>
        </select>
        <label for="expense_vendor_name">Vendor:</label>
        <select name="vendor_name" id="expense_vendor_name">
            <option value=""></option>
            <?php foreach($data['vendors'] as $vendor) { ?>
                <option value="<?= $vendor->name; ?>"><?= $vendor->name; ?></option>
            <?php } ?>
        </select>
        <label for="expense_account_name">Account:</label>
        <select name="account_name" id="expense_account_name">
            <option value=""></option>
            <?php foreach($data['accounts'] as $account) { ?>
                <option value="<?= $account->name; ?>"><?= $account->name; ?></option>
            <?php } ?>
        </select>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount">
        <label for="date">Date:</label>
        <input type="text" id="datepicker" name="selected_date" value="<?= date('Y-m-d'); ?>">
        <input type="submit" value="Create Expense">
    </form>

    <!--SCRIPTS_PLACEHOLDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    <script src="/js/update_dropdown.js" type="text/javascript"></script>
    <script src="/js/modals_tables.js" type="text/javascript"></script>
    

</body>
</html>
