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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h2>Вход</h2>
                    </div>
                    <div class="card-body">
                        <form action="login/loginUser" method="post" data-response="loginMsg">
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин</label>
                                <input type="text" placeholder="Логин" name="login" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password"  placeholder="Пароль" name="password" class="form-control">
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary w-100">Войти</button>
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
