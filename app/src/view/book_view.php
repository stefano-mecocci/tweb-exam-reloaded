<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/book.css">
    <script src="/assets/js/book.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <article class="book">
            <div class="book__figure">
                <img src="<?= get_cover_path($book["id"]) ?>" alt="">
            </div>
            <div class="book__id"><?= $book["id"] ?></div>
            <div class="book__description">
                <h1><?= $book["title"] ?></h1>
                <p><?= $book["description"] ?></p>
                <span><?= $book["authors"] ?></span>
                <span><?= $book["pages"] ?> pagine</span>
                <span><?= formatAvgMark($book["avgMark"]) ?></span>
                <span><?= format_price($book["price"]) ?></span>

                <div class="field">
                    <label for="quantity" class="field__label">Seleziona la quantità</label>
                    <input class="field__input field__input-number" type="number" name="quantity" id="quantity" min="1"
                        max="500" value="1">
                </div>

                <button id="addToCartBtn">Aggiungi al carrello</button>
            </div>
        </article>

        <section class="reviews">
            <h1>Recensioni</h1>

            <form class="reviews__form">
                <textarea class="field__input" name="body" id="body" cols="30" rows="10"
                    placeholder="Scrivi la tua recensione"></textarea>
                <input class="field__input field__input-number" type="number" name="mark" id="mark" min="1" max="5"
                    placeholder="Stelle">

                <input id="publishReviewBtn" type="button" value="Pubblica">
            </form>

            <?php foreach ($reviews as $review): ?>
                <article class="review">
                    <h2><?= getUserFullname($review["user_id"]) ?></h2>
                    <p><?= $review["body"] ?></p>
                    <span class="review__details"><?= $review["mark"] ?> stelle su 5</span> --
                    <span class="review__details"><?= timestampToDate($review["writing_date"]) ?></span>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <?php include "partials/footer.php"; ?>
</body>

</html>