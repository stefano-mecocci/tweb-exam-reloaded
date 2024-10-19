<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/error.css">
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <i class="fas fa-frown error__icon"></i>
        <h1 class="error__title"><?= $error ?></h1>
        <a class="error__link" href="/shop">Torna alla homepage</a>
    </main>
</body>

</html>