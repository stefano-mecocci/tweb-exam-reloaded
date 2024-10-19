function setupFilters() {
    let password = new FieldValidator($("#password"));
    password.addFilter(notEmptyFilter());
    password.addFilter(lengthFilter(3, 100));

    return [password];
}

$(function() {
    const fields = setupFilters();

    $("#switchPassword").click(function() {
        let old = $("#password").attr("type");

        $(this).toggleClass("fa-eye-slash");
        $(this).toggleClass("fa-eye");

        if (old == "text") {
            $("#password").attr("type", "password");
        } else {
            $("#password").attr("type", "text");
        }
    });

    $("#loginForm").on("submit", function(e) {
        for (let field of fields) {
            if (!field.checkFilters()) {
                e.preventDefault();
            }
        }
    });
});