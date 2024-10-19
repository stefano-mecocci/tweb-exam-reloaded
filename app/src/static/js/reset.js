const ONLYLETTERS_REGEX = /^[A-Za-z]+$/;
const EMAIL_REGEX = /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-z]+$/;

function inQuestions() {
    return function(v) {
        const valids = [
            "Qual è il tuo animale preferito?",
            "Qual è il nome di tua nonna?",
            "Qual è il nome della tua città natale?"
        ];

        let result = { valid: valids.includes(v), reason: null };

        if (!result.valid) {
            result.reason = "Domanda non valida";
        }

        return result;
    };
}

function setupFilters() {
    let email = new FieldValidator($("#email"));
    email.addFilter(notEmptyFilter());
    email.addFilter(lengthFilter(6, 100));
    email.addFilter(regexFilter(EMAIL_REGEX));

    let question = new FieldValidator($("#question"));
    question.addFilter(notEmptyFilter());
    question.addFilter(inQuestions());

    let answer = new FieldValidator($("#answer"));
    answer.addFilter(notEmptyFilter());
    answer.addFilter(lengthFilter(3, 50));
    answer.addFilter(regexFilter(ONLYLETTERS_REGEX));

    return [email, question, answer];
}

$(function() {
    const fields = setupFilters();

    $("#resetForm").on("submit", function(e) {
        for (let field of fields) {
            if (!field.checkFilters()) {
                e.preventDefault();
            }
        }
    });
});