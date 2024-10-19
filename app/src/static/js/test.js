const PASSWORD_REGEX = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

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
                reason: "valore troppo lungo o corto"
            };
        }
    };
}

function highlightField(field, reason) {
    field.addClass("input-error")
    field.next().text(reason);
}

function translateField(id) {
    let t = {
        "email": "email"
    };

    return t[id];
}

class FieldValidator {
    constructor(field) {
        this.field = field;
        this.fieldName = translateField(field.attr("id"));
        this.notifyMessage = "";
        this.filters = []
    }

    addFilter(filt) {
        this.filters.push(filt);
    }

    checkFilters() {
        if (this.field.length <= 0) {
            return false;
        }

        for (let fi of this.filters) {
            let filtResult = fi(this.field.val());

            if (!filtResult.valid) {
                highlightField(this.field, filtResult.reason);
                console.log(this.fieldName + ":" + filtResult.reason);
                return false;
            }
        }

        return true;
    }
}

$(function() {
    // setup filtri
    let em = $("#email");
    let x = new FieldValidator(em);
    x.addFilter(notEmptyFilter())
    x.addFilter(lengthFilter(3, 20));

    let pw = $("#password");
    let y = new FieldValidator($("#password"));
    y.addFilter(notEmptyFilter());
    y.addFilter(regexFilter(PASSWORD_REGEX));

    // se ci clicco e faccio focus torna normale
    $(".field__input").focus(function() {
        $(this).removeClass("input-error");
        $(this).next().text("");
    });


    $("#send").on("submit", function(e) {
        e.preventDefault();

        // controllo filtri 
        x.checkFilters();
        y.checkFilters();
    });
});