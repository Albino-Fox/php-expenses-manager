<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Регистрация</title>
</head>
<body>
    <!--NAVBAR_PLACEHOLDER-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h2>Регистрация</h2>
                    </div>
                    <div class="card-body">
                        <form action="register/createUser" method="post" data-response="registerMsg">
                            <div class="mb-3">
                                <label for="reg_login" class="form-label">Логин</label>
                                <input type="text" id="reg_login" name="login" class="form-control" placeholder="Логин">
                            </div>
                            <div class="mb-3">
                                <label for="reg_password" class="form-label">Пароль</label>
                                <input type="password" id="reg_password" name="password" class="form-control" placeholder="Пароль">
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
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
