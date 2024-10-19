function _updateForm() {
    $("#password").val("");
    $(".user__name").text($("#firstName").val() + " " + $("#lastName").val());
}

function updateUser(user) {
    sendJSONData({
        url: "update_user.php",
        data: user,
        successCallback: function(data) {
            _updateForm();
        }
    });
}

const PASSWORD_REGEX = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
const ONLYLETTERS_REGEX = /^[A-Za-z]+$/;
const EMAIL_REGEX = /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-z]+$/;

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
    email.addFilter(lengthFilter(3, 100));
    email.addFilter(regexFilter(EMAIL_REGEX));

    let address = new FieldValidator($("#address"));
    address.addFilter(notEmptyFilter());
    address.addFilter(lengthFilter(6, 100));

    return [firstName, lastName, email, address];
}

// MAIN
$(function() {
    let fields = setupFilters();

    $("#updateUserBtn").click(function() {
        let user = {};

        $("#updateUserForm input[name]").each(function() {
            const fieldName = $(this).attr("name");
            const fieldValue = $(this).val().trim();
            user[fieldName] = fieldValue;
        });

        for (let field of fields) {
            if (!field.checkFilters()) {
                return;
            }
        }

        if ($("#password").val().trim() != "") {
            let password = new FieldValidator($("#password"));
            password.addFilter(regexFilter(PASSWORD_REGEX));

            if (!password.checkFilters()) {
                return;
            }
        }

        updateUser(user);
    });
});