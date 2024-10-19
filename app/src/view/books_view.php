<!DOCTYPE html>
<html lang="it">

<head>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/assets/css/books.css">
    <script src="/assets/js/books.js"></script>
</head>

<body>
    <?php include "partials/header.php"; ?>

    <!-- Form a scomparsa per vendere un nuovo libro -->
    <form class="modal" id="sellForm">
        <!-- TITOLO -->
        <div class="field">
            <label for="title" class="field__label">Titolo</label>
            <input class="field__input" type="text" name="title" id="title" required>
            <span class="field__error"></span>
        </div>

        <!-- AUTORE -->
        <div class="field">
            <label for="authors" class="field__label">Autore/i</label>
            <input class="field__input" type="text" name="authors" id="authors" required>
            <span class="field__error"></span>
        </div>
        <div class="field__info">
            <p>Per inserire più di un autore separarli con virgola. Es. a,b,c</p>
        </div>

        <!-- GENERI -->
        <div class="field">
            <label for="genre" class="field__label">Generi</label>
            <select name="genre[]" id="genre" class="field__input" multiple>
                <option value="fantasia">Fantasia</option>
                <option value="giallo">giallo</option>
                <option value="rosa">rosa</option>
                <option value="poliziesco">poliziesco</option>
            </select>
            <span class="field__error"></span>
        </div>

        <!-- DESCRIZIONE -->
        <div class="field">
            <label for="description" class="field__label">Descrizione</label>
            <textarea class="field__input" name="description" id="description" cols="30" rows="10"></textarea>
            <span class="field__error"></span>
        </div>

        <!-- PREZZO -->
        <div class="field">
            <label for="price" class="field__label">Prezzo</label>
            <input type="text" name="price" id="price" class="field__input field__input-number">
            <span class="field__error"></span>
        </div>
        <div class="field__info">
            <p>Es. di prezzo 19,00</p>
        </div>

        <!-- PAGINE -->
        <div class="field">
            <label for="pages" class="field__label">Pagine</label>
            <input type="number" name="pages" id="pages" class="field__input field__input-number" min="20" max="3000">
            <span class="field__error"></span>
        </div>

        <!-- QUANTITà -->
        <div class="field">
            <label for="quantity" class="field__label">Quantità</label>
            <input type="number" name="quantity" id="quantity" class="field__input field__input-number" min="50"
                max="10000">
            <span class="field__error"></span>
        </div>

        <div class="field">
            <label for="cover" class="field__label">Copertina</label>
            <input type="file" name="cover" id="cover">
            <span class="field__error"></span>
        </div>

        <input id="sellBookBtn" class="modal__btn" type="button" value="Pubblica">
        <input class="modal__btn closeModal" type="button" value="Chiudi">
    </form>

    <main>
        <h1 class="books__title">Vendite</h1>
        <hr>

        <!-- Trigger per far comparire il form -->
        <button class="block-btn openForm" data-form-id="sellForm">Vendi</button>
        <hr>

        <!-- Prodotti messi in vendita dall'utente -->
        <div class="books">
            <?php if (empty($books)): ?>
                <h1 id="emptyList" style="display: block;">Non hai ancora venduto nulla</h1>
            <?php else: ?>
                <h1 id="emptyList" style="display: none;">Non hai ancora venduto nulla</h1>
            <?php endif; ?>

            <?php foreach ($books as $book): ?>
                <article class="book">
                    <div class="book__picture">
                        <img src="<?= get_cover_path($book["id"]) ?>" alt="">
                    </div>

                    <div class="book__id"><?= $book["id"] ?></div>

                    <div class="book__description">
                        <p><?= $book["title"] ?></p>
                        <p><?= format_price($book["price"]) ?></p>
                    </div>

                    <div class="book__controls">
                        <a href="book/<?= $book["id"] ?>">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        <i class="fas fa-trash-alt deleteBook"></i>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>