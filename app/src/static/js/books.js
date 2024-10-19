// create the book element
function _createBookElem(book, bookId) {
    let bookElem = $('<div></div>').addClass('book');

    let bookPicture = $('<div></div>').addClass('book__picture');
    let bookImage =
        $('<img>').attr('src', '/books_covers/cover' + bookId + '.jpg');
    bookPicture.append(bookImage);

    let bookIdDiv = $('<div></div>').addClass('book__id').text(bookId);

    let bookDescription = $('<div></div>').addClass('book__description');
    bookDescription.append($('<p></p>').text(book['title']));
    bookDescription.append($('<p></p>').text('€' + book['price']));

    let bookControls = $('<div></div>').addClass('book__controls');
    let bookLink = $('<a></a>').attr('href', 'book/' + bookId);
    bookLink.append($('<i></i>').addClass('fas fa-info-circle'));
    bookControls.append(bookLink);
    bookControls.append($('<i></i>').addClass('fas fa-trash-alt deleteBook'));

    bookElem.append(bookPicture);
    bookElem.append(bookIdDiv);
    bookElem.append(bookDescription);
    bookElem.append(bookControls);

    return bookElem;
}

// add a book element to the DOM inside .books
function _addBookElem(book, bookId) {
    let books = $('.books');
    let bookElem = _createBookElem(book, bookId);

    books.append(bookElem);
}

// convert book object to form data to send over ajax
function _prepareBookFormData(book) {
    let formData = new FormData();

    for (const [key, value] of Object.entries(book)) {
        if (key == 'genre[]') {
            for (let v of value) {
                formData.append(key, v);
            }
        } else {
            formData.append(key, value);
        }
    }

    formData.append('cover', $('#cover').prop('files')[0]);

    return formData;
}

function sellBook(book) {
    sendFormData({
        url: 'create_book.php',
        data: _prepareBookFormData(book),
        successCallback: function(data) {
            _addBookElem(book, data.data.id);
            cleanAllForms();
            closeModals();
            $("#emptyList").hide();
        }
    });
}

function checkPrice(v) {
    if (!(/[0-9]+,[0-9]{2}/).test(v)) {
        return { valid: false, reason: 'formato non valido' };
    }

    let price = v.trim().replace(',', '');
    price = Number.parseInt(price);

    if (price >= 500 && price <= 50000) {
        return { valid: true, reason: null };
    } else {
        return { valid: false, reason: 'Il prezzo è troppo o poco' };
    }
}

function checkAuthors(v) {
    let authors = v.split(",");

    for (let a of authors) {
        if (a.length < 3 || a.length > 40) {
            return { valid: false, reason: "Un autore è troppo lungo o troppo corto" };
        }

        if (!(/^[^0-9]*$/).test(a)) {
            return { valid: false, reason: "Un autore non va bene" };
        }
    }

    return { valid: true, reason: null };
}

function setupFilters() {
    let title = new FieldValidator($('#title'));
    title.addFilter(notEmptyFilter())
    title.addFilter(lengthFilter(3, 40));
    title.addFilter(regexFilter(/^[^0-9]*$/));

    let author = new FieldValidator($('#authors'));
    author.addFilter(notEmptyFilter());
    author.addFilter(checkAuthors);

    let genre = new FieldValidator($('#genre'));
    genre.addFilter(v => {
        let result = { valid: v.length > 0, reason: null };

        if (!result.valid) {
            result.reason = 'Seleziona almeno un genere';
        }

        return result;
    });

    let description = new FieldValidator($('#description'));
    description.addFilter(notEmptyFilter());
    description.addFilter(lengthFilter(30, 3000));

    let price = new FieldValidator($('#price'));
    price.addFilter(notEmptyFilter());
    price.addFilter(checkPrice);

    let quantity = new FieldValidator($('#quantity'));
    quantity.addFilter(notEmptyFilter());
    quantity.addFilter(intRangeFilter(50, 10000));

    let pages = new FieldValidator($('#pages'));
    pages.addFilter(notEmptyFilter());
    pages.addFilter(intRangeFilter(20, 3000));

    let cover = new FieldValidator($("#cover"));
    cover.addFilter(v => {
        return { valid: v != "", reason: "Copertina obbligatoria" };
    });

    return [title, author, genre, description, price, quantity, pages, cover];
}

// MAIN

$(function() {
    let fields = setupFilters();

    // rimuovi un libro dalle vendite
    $('.books').click(function(e) {
        if ($(e.target).hasClass('deleteBook')) {
            removeBookFromList($(e.target), 'delete_book.php');
        }
    });

    // aggiunta di un libro alla vendita
    $('#sellBookBtn').click(function() {
        let book = {};

        $('#sellForm [name]').each(function() {
            const fieldName = $(this).attr('name');
            let fieldValue = $(this).val();

            if (typeof fieldValue === 'string' || fieldValue instanceof String) {
                fieldValue = fieldValue.trim();
            }

            book[fieldName] = fieldValue;
        });

        for (let validator of fields) {
            if (!validator.checkFilters()) {
                return;
            }
        }

        console.log(book);
        sellBook(book);
    });
});