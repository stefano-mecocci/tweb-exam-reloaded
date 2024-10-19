/*
===============================================================
VALIDATION
===============================================================
*/

function regexFilter(regex) {
    return function(v) {
        if (regex.test(v)) {
            return { valid: true, reason: null };
        } else {
            return {
                valid: false,
                reason: "valore non valido"
            };
        }
    };
}

function notEmptyFilter() {
    return function(v) {
        if (v.length > 0 && v != "") {
            return { valid: true, reason: null };
        } else {
            return {
                valid: false,
                reason: "valore vuoto"
            };
        }
    };
}

function lengthFilter(minlen, maxlen) {
    return function(v) {
        if (v.length >= minlen && v.length <= maxlen) {
            return { valid: true, reason: null };
        } else {
            return {
                valid: false,
                reason: "valore troppo lungo o troppo corto"
            };
        }
    };
}

function intRangeFilter(min, max) {
    return function(v) {
        const n = Number.parseInt(v);

        if (n >= min && n <= max) {
            return { valid: true, reason: null };
        } else {
            return {
                valid: false,
                reason: "numero troppo grande o troppo piccolo"
            };
        }
    };
}

function highlightField(field, reason) {
    console.log(field, reason);
    field.addClass("input-error")
    field.next().text(reason.charAt(0).toUpperCase() + reason.slice(1));
    field.focus();
}

class FieldValidator {
    constructor(field) {
        this.field = field;
        this.notifyMessage = "";
        this.filters = []
    }

    addFilter(filter) {
        this.filters.push(filter);
    }

    checkFilters() {
        if (this.field.length <= 0) {
            return false;
        }

        for (let fi of this.filters) {
            let filtResult = fi(this.field.val());

            if (!filtResult.valid) {
                highlightField(this.field, filtResult.reason);
                return false;
            }
        }

        return true;
    }
}

/*
===============================================================
NOTIFICATIONS
===============================================================
*/

function _createAlert(type, text) {
    let alertElem = $("<div></div>").addClass("alert");

    alertElem.addClass((type == "error") ? "alert-error" : "alert-success");
    alertElem.text(text);

    return alertElem;
}

function _notify(type, msg) {
    let alert = _createAlert(type, msg);

    if ($("#notification-area").children().length < 3) {
        $("#notification-area").append(alert);

        setTimeout(function() {
            alert.fadeOut(400, function() {
                $(this).remove();
            });
        }, 4000);
    } else {
        alert.remove();
    }
}

function notifyError(msg) {
    _notify("error", msg);
}

function notifySuccess(msg) {
    _notify("success", msg);
}

/*
===============================================================
FORMS
===============================================================
*/

function cleanAllForms() {
    $("input:not([type='button'])").each(function() {
        $(this).val("");
    });

    $("textarea").each(function() {
        $(this).val("");
    });

    $("option:selected").prop("selected", false);
}

function closeModals() {
    $(".modal").hide();
    $("#overlay").hide();
}

/*
===============================================================
AJAX
===============================================================
*/

// send Form data to server (provide page, data and successCallback)
function sendFormData(options) {
    $.ajax({
        url: "/api/" + options.url,
        processData: false,
        contentType: false,
        data: options.data,
        success: function(data) {
            $(".loading").removeClass("is-visible");

            if (data.status == "ok") {
                notifySuccess(data.reason);
                options.successCallback(data);
            } else {
                notifyError(data.reason);
            }
        }
    });
}

// send JSON data to server (provide page, data and successCallback)
function sendJSONData(options) {
    $(".loading").addClass("is-visible");

    $.ajax({
        url: "/api/" + options.url,
        data: options.data,
        success: function(data) {
            $(".loading").removeClass("is-visible");

            if (data.status == "ok") {
                notifySuccess(data.reason);
                options.successCallback(data);
            } else {
                notifyError(data.reason);
            }
        }
    });
}

function formatPrice(price) {
    let result = price + "";

    return result.slice(0, -2) + "," + result.slice(-2);
}

function updateTotalPrice() {
    let tmpNewTotal = 0;

    $(".book__description p:nth-child(2)").each(function() {
        let price = $(this).text().trim();
        price = price.replace(",", "");
        price = price.replace("€", "");
        price = price.replace(" ", "");

        tmpNewTotal += Number.parseInt(price);
    });

    $("#total").text("Totale: " + formatPrice(tmpNewTotal) + " €");
}

// remove a book from a list of books
function removeBookFromList(deleteBtn, url) {
    let bookElem = deleteBtn.parent().parent();
    const data = {
        bookId: bookElem.find(".book__id").text().trim()
    };

    sendJSONData({
        url: url,
        data: data,
        successCallback: function(data) {
            bookElem.next("hr").remove();
            bookElem.remove();

            updateTotalPrice();

            if ($(".books").children().length == 1) {
                $(".payment-form").hide();
                $("#emptyList").css("display", "block");
            }
        }
    });
}

// prepare the base for future ajax calls
function _setupAjaxCalls() {
    $.ajaxSetup({
        dataType: 'json',
        type: 'post',
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);

            $(".loading").removeClass("is-visible");
            notifyError("Errore dal server");
        }
    });
}



/*
===============================================================
MAIN
===============================================================
*/

$(function() {
    _setupAjaxCalls();

    // se ci clicco e faccio focus torna normale
    $(".field__input").on("click keypress", function() {
        $(this).removeClass("input-error");
        $(this).next().text("");
    });

    // open the form associated with data-form-id attribute
    $(".openForm").click(function() {
        let form = $("#" + $(this).data("formId"));

        $("#menu").hide();
        form.show();
        $("#overlay").show();
    });

    // close open modals (if any)
    $(".closeModal").click(function(e) {
        closeModals();
    });

    // open/close menu
    $("#menuButton").click(function() {
        $("#menu").toggle();
    });

    // remove a notification by clicking on it
    $("#notification-area").click(function(e) {
        if (e.target.nodeName == "DIV") {
            $(e.target).remove();
        }
    });
});