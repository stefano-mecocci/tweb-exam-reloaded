<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/login.css">
    <script src="/assets/js/reset.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <h1 class="form__title">Reset</h1>

        <form action="api/reset.php" method="post" id="resetForm">
            <div class="field">
                <label for="email" class="field__label">Email</label>
                <input class="field__input" type="email" name="email" id="email" required>
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

            <input class="form__submit" type="submit" value="Reimposta password">
        </form>
    </main>
</body>

</html>