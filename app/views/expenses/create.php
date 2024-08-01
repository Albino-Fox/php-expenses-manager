<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Добавить расходы</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->

    <div class="container mt-3 mb-3">
        <div class="row">
            <!-- Category Form -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">Добавить категорию</div>
                    <div class="card-body">
                        <form id="create_category_form" method="POST" action="/expenses/createCategory" data-response="categoryMsg">
                            <label for="category_name" class="form-label">Название категории:</label>
                            <input type="text" id="category_name" name="category_name" class="form-control">
                            <input type="submit" value="Добавить категорию" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Vendor Form -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">Добавить продавца</div>
                    <div class="card-body">
                        <form id="create_vendor_form" method="POST" action="/expenses/createVendor" data-response="vendorMsg">
                            <label for="vendor_name" class="form-label">Название продавца:</label>
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control">
                            <input type="submit" value="Добавить продавца" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Account Form -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">Добавить счет</div>
                    <div class="card-body">
                        <form id="create_account_form" method="POST" action="/expenses/createAccount" data-response="accountMsg">
                            <label for="account_name" class="form-label">Название счета:</label>
                            <input type="text" id="account_name" name="account_name" class="form-control">
                            <input type="submit" value="Добавить счет" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Просмотр и редактирование данных</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-1">
                                <button type="button" class="btn btn-secondary w-100 h-100" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    Редактировать категории
                                </button>
                            </div>

                            <div class="col mt-1">
                                <button type="button" class="btn btn-secondary w-100 h-100" data-bs-toggle="modal" data-bs-target="#vendorModal">
                                    Редактировать продавцов
                                </button>
                            </div>

                            <div class="col mt-1">
                                <button type="button" class="btn btn-secondary w-100 h-100" data-bs-toggle="modal" data-bs-target="#accountModal">
                                    Редактировать счета
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="categoryModalLabel">Категории</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="categoryTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Название</th>
                <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedCategories">Удалить выбранные</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Vendor Modal -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="vendorModalLabel">Продавцы</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="vendorTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Название</th>
                <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedVendors">Удалить выбранные</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Account Modal -->
    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="accountModalLabel">Счета</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="accountTable" class="table table-striped">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Название</th>
                <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <!-- This will be populated by JavaScript -->
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSelectedAccounts">Удалить выбранные</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="editName" class="form-control">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="editType">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveEdit">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>


    
    
    <!-- Expense Form -->
    <div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Записать транзакцию</div>
                    <div class="card-body">
                        <form id="expense_form" method="POST" action="/expenses/createExpense" data-response="expenseMsg">
                            <label for="expense_category_name" class="form-label">Категория:</label>
                            <select name="category_name" id="expense_category_name" class="form-select">
                                <option value=""></option>
                                <?php foreach($data['categories'] as $category) { ?>
                                    <option value="<?= $category->name; ?>"><?= $category->name; ?></option>
                                <?php } ?>
                            </select>
                            <label for="expense_type_name" class="form-label mt-2">Тип:</label>
                            <select name="expense_type" id="expense_type_name" class="form-select">
                                <option value="E">Расход</option>
                                <option value="I">Доход</option>
                            </select>
                            <label for="expense_vendor_name" class="form-label mt-2">Продавец (опцинонально):</label>
                            <select name="vendor_name" id="expense_vendor_name" class="form-select">
                                <option value=""></option>
                                <?php foreach($data['vendors'] as $vendor) { ?>
                                    <option value="<?= $vendor->name; ?>"><?= $vendor->name; ?></option>
                                <?php } ?>
                                </select>
                            <label for="expense_account_name" class="form-label mt-2">Счет (опцинонально):</label>
                            <select name="account_name" id="expense_account_name" class="form-select">
                                <option value=""></option>
                                <?php foreach($data['accounts'] as $account) { ?>
                                    <option value="<?= $account->name; ?>"><?= $account->name; ?></option>
                                <?php } ?>
                            </select>
                            <label for="amount" class="form-label mt-2">Сумма:</label>
                            <input type="text" id="amount" name="amount" class="form-control">
                            <label for="date" class="form-label mt-2">Дата:</label>
                            <input type="text" class="datepicker form-control" name="selected_date" value="<?= date('Y-m-d'); ?>">
                            <label for="comment" class="form-label mt-2">Комментарий (опцинонально):</label>
                            <input type="text" id="comment" name="comment" class="form-control">
                            <input type="submit" value="Записать транзакцию" class="btn btn-primary mt-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--SCRIPTS_PLACEHOLDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    <script src="/js/update_dropdown.js" type="text/javascript"></script>
    <script src="/js/modals_tables.js" type="text/javascript"></script>
    

</body>
</html>
