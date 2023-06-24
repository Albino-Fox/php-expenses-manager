<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Вход</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Вход</h2>
                        <form action="login/loginUser" method="post" data-response="loginMsg">
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="login" name="login" placeholder="Введите логин">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Войти</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--SCRIPTS_PLACEHOLDER-->
</body>
</html>
