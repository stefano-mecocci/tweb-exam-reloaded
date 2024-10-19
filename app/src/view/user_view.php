<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/user.css">
    <script src="/assets/js/user.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <div class="user__picture">
            <img src="/assets/img/profile.png" alt="">
        </div>
        <h1 class="user__name"><?= getUserFullname($user) ?></h1>

        <form class="user__info" id="updateUserForm">
            <div class="field__info">
                <p>Per cambiare informazioni: cambiare i valori e premere aggiorna. Se si lascia il campo password vuoto
                    essa rimane invariata.</p>
            </div>

            <div class="field">
                <label for="firstName" class="field__label">Nome</label>
                <input class="field__input" type="text" name="firstName" id="firstName"
                    value="<?= $user["first_name"] ?>" required>
                <span class="field__error"></span>
            </div>

            <div class="field">
                <label for="lastName" class="field__label">Cognome</label>
                <input class="field__input" type="text" name="lastName" id="lastName" value="<?= $user["last_name"] ?>"
                    required>
                <span class="field__error"></span>
            </div>

            <div class="field">
                <label for="email" class="field__label">Email</label>
                <input class="field__input" type="email" name="email" id="email" value="<?= $user["email"] ?>" required>
                <span class="field__error"></span>
            </div>

            <div class="field">
                <label for="password" class="field__label">Password</label>
                <input class="field__input" type="text" name="password" id="password" value="" required>
                <span class="field__error"></span>
            </div>
            <div class="field__info">
                <p>La password deve contenere:</p>
                <ul>
                    <li>Almeno una lettera minuscola</li>
                    <li>Almeno una lettera maiuscola</li>
                    <li>Almeno un numero</li>
                    <li>Almeno un carattere speciale</li>
                </ul>
            </div>

            <div class="field">
                <label for="address" class="field__label">Indirizzo</label>
                <input class="field__input" type="text" name="address" id="address" value="<?= $user["address"] ?>"
                    required>
                <span class="field__error"></span>
            </div>

            <input id="updateUserBtn" class="form__submit" type="button" value="Aggiorna informazioni">
        </form>
    </main>
</body>

</html>