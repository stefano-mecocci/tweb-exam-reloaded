<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/books.css">
    <link rel="stylesheet" href="/assets/css/cart.css">
    <script src="/assets/js/cart.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <main>
        <h1 class="books__title">Carrello</h1>
        <hr>

        <div class="books">
            <?php if (empty($cartBooks)): ?>
                <h1 id="emptyList" style="display: block;">Il carrello è vuoto</h1>
            <?php else: ?>
                <h1 id="emptyList" style="display: none;">Il carrello è vuoto</h1>
            <?php endif; ?>

            <?php foreach ($cartBooks as $book): ?>
                <div class="book">
                    <div class="book__picture">
                        <img src="<?= get_cover_path($book["id"]) ?>" alt="">
                    </div>

                    <div class="book__id"><?= $book["cart_id"] ?></div>

                    <div class="book__description">
                        <p><?= $book["title"] ?></p>
                        <p><?= format_price($book["price"]) ?></p>
                        <p>Quantità: <?= $book["cart_quantity"] ?></p>
                    </div>

                    <div class="book__controls">
                        <a href="book/<?= $book["id"] ?>"><i class="fas fa-info-circle"></i></a>
                        <i class="fas fa-trash-alt deleteBook"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($cartBooks)): ?>
            <form class="payment-form">
                <p id="total">Totale: <?= format_price($total) ?></p>
                <p>Indirizzo: <?= $user["address"] ?></p>

                <p>Scegli la carta da usare:</p>
                <input class="block-btn openForm" data-form-id="addCardForm" type="button" value="Aggiungi una carta">
                <select name="card" id="cards">
                    <?php foreach ($cards as $card): ?>
                        <option value="<?= $card["card_number"] ?>"><?= $card["card_number"] ?></option>
                    <?php endforeach; ?>
                </select>

                <input class="block-btn" id="payButton" type="button" value="Paga">
            </form>
        <?php endif; ?>

        <div class="modal" id="addCardForm">
            <div class="field">
                <label for="number" class="field__label">Numero di carta</label>
                <input class="field__input" type="number" name="number" id="number">
                <span class="field__error"></span>
            </div>

            <div class="field">
                <label for="cvv" class="field__label">CVV</label>
                <input class="field__input" type="number" name="cvv" id="cvv" min="100" max="999">
                <span class="field__error"></span>
            </div>

            <div class="field">
                <label for="expiringDate" class="field__label">Data di scadenza</label>
                <input type="date" name="expiringDate" id="expiringDate" class="field__input" min="2022-01-11">
                <span class="field__error"></span>
            </div>

            <input class="modal__btn" id="addCardBtn" type="button" value="Aggiungi">
            <input class="modal__btn closeModal" type="button" value="Annulla">
        </div>
    </main>
</body>

</html>