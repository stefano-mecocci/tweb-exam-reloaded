<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/shop.css">
    <script src="/assets/js/shop.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <!-- Sezione: ricerca -->
        <form class="search">
            <input class="search__input" type="text" id="title" placeholder="Cerca per titolo">
        </form>

        <div class="cart" title="Trascina qui per aggiungere al carrello">
            <i class="fas fa-cart-plus"></i>
        </div>

        <!-- Sezione: prodotti -->
        <div class="cards">

            <?php foreach ($books as $book): ?>
                    <article class="card draggable">
                        <i class="fas fa-arrows-alt card__drag-area"
                            title="Trascinami a destra per aggiungermi al carrello"></i>
                        <figure class="card__figure">
                            <img src="<?= get_cover_path($book["id"]) ?>" alt="Copertina di '<?= $book["title"] ?>'"
                                draggable="false">
                        </figure>
                        <div class="card__id"><?= $book["id"] ?></div>
                        <div class="card__description">
                            <span class="card__description__title"> <a href="book/<?= $book["id"] ?>"> <?= $book["title"] ?>
                                </a> </span>
                            <span class="card__description__price"><?= format_price($book["price"]) ?></span>
                            <span class="card__description__mark"><?= formatAvgMark($book["avgMark"]) ?></span>
                        </div>
                    </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>