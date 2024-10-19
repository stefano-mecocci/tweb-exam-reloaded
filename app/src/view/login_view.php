<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/login.css">
    <script src="/assets/js/login.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <h1 class="form__title">Login</h1>

        <form action="api/login.php" method="post" id="loginForm">
            <div class="field">
                <label for="email" class="field__label">Email</label>
                <input class="field__input" type="email" name="email" id="email" required>
                <span class="field__error"></span>
            </div>

            <div class="field" style="position: relative;">
                <i class="fas fa-eye" id="switchPassword"></i>
                <label for="password" class="field__label">Password</label>
                <input class="field__input" type="password" name="password" id="password" required>
                <span class="field__error"></span>
            </div>

            <input class="form__submit" type="submit" value="Accedi">
        </form>

        <p class="form__switch">
            <span>Sei un nuovo cliente?</span>
            <a href="/register">Registrati</a>
        </p>
        <p class="form__switch">
            <span>Hai dimenticato la password?</span>
            <a href="/reset">Reimpostala</a>
        </p>
    </main>
</body>

</html>