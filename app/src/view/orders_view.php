<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/books.css">
    <script src="/assets/js/orders.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <h1 class="books__title">Ordini</h1>
        <hr>

        <div class="books">
            <?php if (empty($orders)): ?>
                <h1 id="emptyList" style="display: block;">Non ci sono ancora ordini</h1>
            <?php else: ?>
                <h1 id="emptyList" style="display: none;">Non ci sono ancora ordini</h1>
            <?php endif; ?>

            <?php foreach ($orders as $order): ?>
                <div class="book">
                    <div class="book__picture">
                        <img src="<?= get_cover_path($order["book_id"]) ?>" alt="Libro">
                    </div>

                    <div class="book__id"><?= $order["id"] ?></div>

                    <div class="book__description">
                        <p><?= $order["title"] ?></p>
                        <p><?= format_price($order["price"]) ?></p>
                        <p>Arriva il: <?= rand(1, 31) ?> marzo</p>
                        <p>Ordinato il: <?= timestampToDate($order["order_date"]) ?></p>
                        <p>Quantità: <?= $order["quantity"] ?></p>
                    </div>

                    <div class="book__controls">
                        <a href="book/<?= $order["book_id"] ?>"><i class="fas fa-info-circle"></i></a>
                        <i class="fas fa-trash-alt deleteBook"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>