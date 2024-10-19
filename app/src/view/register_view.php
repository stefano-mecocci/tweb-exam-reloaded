<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/login.css">
    <script src="/assets/js/register.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <h1 class="form__title">Registrazione</h1>

        <form action="api/register.php" method="post" id="registerForm">
            <!-- NOME -->
            <div class="field">
                <label for="firstName" class="field__label">Nome</label>
                <input class="field__input" type="text" name="firstName" id="firstName" required>
                <span class="field__error"></span>
            </div>

            <!-- COGNOME -->
            <div class="field">
                <label for="lastName" class="field__label">Cognome</label>
                <input class="field__input" type="text" name="lastName" id="lastName" required>
                <span class="field__error"></span>
            </div>

            <!-- EMAIL -->
            <div class="field">
                <label for="email" class="field__label">Email</label>
                <input class="field__input" type="text" name="email" id="email" required>
                <span class="field__error"></span>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <label for="password" class="field__label">Password</label>
                <input class="field__input" type="text" name="password" id="password" required>
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

            <!-- INDIRIZZO -->
            <div class="field">
                <label for="address" class="field__label">Indirizzo</label>
                <input class="field__input" type="text" name="address" id="address" required>
                <span class="field__error"></span>
            </div>

            <!-- DOMANDA DI SICUREZZA -->
            <div class="field">
                <label for="question" class="field__label">Domanda di sicurezza</label>
                <select class="field__input" name="question" id="question" required>
                    <option value="">Scegli domanda</option>
                    <option value="Qual è il tuo animale preferito?">Qual è il tuo animale preferito?</option>
                    <option value="Qual è il nome di tua nonna?">Qual è il nome di tua nonna?</option>
                    <option value="Qual è il nome della tua città natale?">Qual è il nome della tua città natale?
                    </option>
                </select>
                <span class="field__error"></span>
            </div>

            <!-- E RISPOSTA -->
            <div class="field">
                <label for="answer" class="field__label">Risposta alla domanda</label>
                <input type="text" name="answer" id="answer" class="field__input" required>
                <span class="field__error"></span>
            </div>
            <div class="field__info">
                <p>La domanda di sicurezza serve per resettare la password qualora la si dimentichi. La risposta può
                    contenere solo lettere.</p>
            </div>

            <div class="field field-checkbox">
                <label for="isSeller">Registrati come venditore</label>
                <input type="checkbox" name="isSeller" id="isSeller">
            </div>

            <div class="field__info">
                <p>Registrandoti come venditore puoi mettere in vendita libri</p>
            </div>

            <input class="form__submit" type="submit" value="Registrati">
        </form>

        <p class="form__switch">
            <span>Sei già registrato?</span>
            <a href="/login">Accedi</a>
        </p>
    </main>
</body>

</html>