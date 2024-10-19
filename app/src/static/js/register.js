const PASSWORD_REGEX = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

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
    let firstName = new FieldValidator($("#firstName"));
    firstName.addFilter(notEmptyFilter())
    firstName.addFilter(lengthFilter(3, 40));
    firstName.addFilter(regexFilter(ONLYLETTERS_REGEX));

    let lastName = new FieldValidator($("#lastName"));
    lastName.addFilter(notEmptyFilter());
    lastName.addFilter(lengthFilter(3, 40));
    lastName.addFilter(regexFilter(ONLYLETTERS_REGEX));

    let email = new FieldValidator($("#email"));
    email.addFilter(notEmptyFilter());
    email.addFilter(lengthFilter(6, 100));
    email.addFilter(regexFilter(EMAIL_REGEX));

    let password = new FieldValidator($("#password"));
    password.addFilter(notEmptyFilter());
    password.addFilter(regexFilter(PASSWORD_REGEX));

    let address = new FieldValidator($("#address"));
    address.addFilter(notEmptyFilter());
    address.addFilter(lengthFilter(6, 100));

    let question = new FieldValidator($("#question"));
    question.addFilter(notEmptyFilter());
    question.addFilter(inQuestions());

    let answer = new FieldValidator($("#answer"));
    answer.addFilter(notEmptyFilter());
    answer.addFilter(lengthFilter(3, 50));
    answer.addFilter(regexFilter(ONLYLETTERS_REGEX));

    return [firstName, lastName, email, password, address, question, answer];
}

$(function() {
    const validators = setupFilters();

    $("#registerForm").on("submit", function(e) {
        for (let validator of validators) {
            if (!validator.checkFilters()) {
                e.preventDefault();
                return;
            }
        }

        // procedo alla registrazione lato server
    });
});