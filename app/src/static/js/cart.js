function _addCardElement(card) {
    let cardElem = $("<option></option>");

    cardElem.val(card.number);
    cardElem.text(card.number);

    $("#cards").append(cardElem);
}

function addCard(card) {
    sendJSONData({
        url: "create_card.php",
        data: card,
        successCallback: function(data) {
            _addCardElement(card);
            closeModals();
        }
    });
}

function readCookie(name) {
    let cookiesMap = new Map();
    let cookies;

    if (document.cookie.trim() == "") {
        return undefined;
    }

    cookies = document.cookie.split(";").map(c => c.trim());

    for (let cookie of cookies) {
        let cookieArr = cookie.split("=");
        cookiesMap.set(cookieArr[0], cookieArr[1]);
    }

    return cookiesMap.get(name);
}

function writeCookie(name, value) {
    let cookie = `${name}=${value};`;
    let now = new Date();
    let time = now.getTime();
    let expireTime = time + 1000 * 3600 * 24 * 3;
    now.setTime(expireTime);

    document.cookie = cookie + 'expires=' + now.toUTCString() + ';path=/';
}

function setupFilters() {
    let number = new FieldValidator($("#number"));
    number.addFilter(notEmptyFilter())
    number.addFilter(lengthFilter(16, 16));

    let cvv = new FieldValidator($("#cvv"));
    cvv.addFilter(notEmptyFilter());
    cvv.addFilter(lengthFilter(3, 3));

    let expiringDate = new FieldValidator($("#expiringDate"));
    expiringDate.addFilter(notEmptyFilter());

    return [number, cvv, expiringDate];
}

// MAIN
$(function() {
    let cardValidators = setupFilters();

    // ricorda ultima carta usata
    const lastUsedCart = readCookie("lastUsedCart");

    $('#cards option').each(function() {
        if ($(this).val() === lastUsedCart) {
            $(this).prop("selected", true);
        }
    });

    $('#cards').on('change', function() {
        writeCookie("lastUsedCart", $(this).val());
    });

    // rimuovi un libro dal carrello
    $(".books").click(function(e) {
        if ($(e.target).hasClass("deleteBook")) {
            removeBookFromList($(e.target), 'delete_book_from_cart.php');
        }
    });

    // aggiungi una carta
    $("#addCardBtn").click(function() {
        let card = {};

        $("#addCardForm [name]").each(function() {
            const fieldName = $(this).attr("name");
            const fieldValue = $(this).val().trim();
            card[fieldName] = fieldValue;
        });

        for (let validator of cardValidators) {
            if (!validator.checkFilters()) {
                return;
            }
        }

        addCard(card);
    });

    // dai il via al pagamento di tutti i prodotti nel carrello
    $("#payButton").click(function() {
        if ($(".book").length == 0) {
            notifyError("Non puoi pagare un carrello vuoto");
            return;
        }

        if ($("#cards").val() == null) {
            notifyError("Non puoi pagare senza una carta");
            return;
        }

        sendJSONData({
            url: "pay.php",
            data: {},
            successCallback: function(data) {
                $(".book").remove();
                $(".payment-form").hide();
                $("#emptyList").show();
            }
        });
    });
});