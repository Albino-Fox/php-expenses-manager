<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/home">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="/expenses/createExpense">Создать транзакцию</a></li>
                <li class="nav-item"><a class="nav-link" href="/expenses">Посмотреть транзакции</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php 
                    if(isset($_SESSION['user_id'])) {
                        echo('<span class="navbar-text me-5">Приветствую, ' . $_SESSION['nickname'] . '</span>');
                        echo('<li class="nav-item"><a class="nav-link" href="/logout">Выйти</a></li>');
                    }
                    else {
                        echo('<li class="nav-item"><a class="nav-link" href="/register">Регистрация</a></li>');
                        echo('<li class="nav-item"><a class="nav-link" href="/login">Вход</a></li>');
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>