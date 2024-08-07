<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Транзакции</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <div class="container mt-4 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <h3>Ваши транзакции</h3>
            </div>
            <div class="card-body">
                <table id="expensesTable" class="display">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>Категория</th>
                            <th>Продавец</th>
                            <th>Счёт</th>
                            <th>Сумма</th>
                            <th>Тип</th>
                            <th>Дата</th>
                            <th>Комментарий</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be inserted here dynamically -->
                    </tbody>
                </table>
                <button id="delete-selected" class="btn btn-danger">Удалить выбранное</button>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Анализ</h4>
            </div>
            <div class="card-body">
                <div class="analysis-param">Общий доход: <span id="totalIncome">0</span>&#x20bd;</div>
                <div class="analysis-param">Общий расход: <span id="totalExpenses">0</span>&#x20bd;</div>
                <div class="analysis-param">Баланс: <span id="totalDifference">0</span>&#x20bd;</div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="editExpenseModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать транзакцию</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editExpenseForm">
                <div class="form-group mb-3">
                    <label for="editExpenseCategory">Категория</label>
                    <select class="form-control" id="editExpenseCategory" name="category">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseVendor">Продавец (опцинонально)</label>
                    <select class="form-control" id="editExpenseVendor" name="vendor">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseAccount">Счёт (опцинонально)</label>
                    <select class="form-control" id="editExpenseAccount" name="account"></select>
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseAmount">Сумма</label>
                    <input type="text" class="form-control" id="editExpenseAmount" name="amount">
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseType">Тип</label>
                    <select class="form-control" id="editExpenseType" name="type">
                        <option value="E">Расход</option>
                        <option value="I">Доход</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseDate">Дата</label>
                    <input type="text" class="form-control datepicker" id="editExpenseDate" name="date">
                </div>
                <div class="form-group mb-3">
                    <label for="editExpenseComment">Комментарий (опцинонально)</label>
                    <input type="text" class="form-control" id="editExpenseComment" name="comment">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveChanges">Сохранить изменения</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
            </div>
        </div>
    </div>



    <!--SCRIPTS_PLACEHOLDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="/js/datepicker_widget.js" type="text/javascript"></script>
    <script src="/js/expenses_analysis.js"></script>
    <script src="/js/expenses_table.js"></script>


</body>
</html>
