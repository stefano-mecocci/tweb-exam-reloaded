function _addReviewElem(review) {
    let reviewElem = $("<article></article>").addClass("review");

    reviewElem.append($("<h2></h2>").text("La mia recensione"));
    reviewElem.append($("<p></p>").text(review.body));
    reviewElem.append($("<span></span>").addClass("review__details")
        .text(review.mark + " stelle su 5"));
    reviewElem.append(" -- ");
    reviewElem.append($("<span></span>").addClass("review__details")
        .text("ora"));

    $(".reviews__form").after(reviewElem);
}

function createReview() {
    let review = {
        body: $("#body").val().trim(),
        mark: $("#mark").val(),
        bookId: $(".book__id").text().trim()
    };

    sendJSONData({
        url: "create_review.php",
        data: review,
        successCallback: function(data) {
            cleanAllForms();
            _addReviewElem(review);
        }
    });
}

$(function() {
    // aggiungi libro al carrello
    $("#addToCartBtn").click(function() {
        const data = {
            bookId: $(".book__id").text().trim(),
            quantity: $("#quantity").val()
        };

        sendJSONData({
            url: "add_book_to_cart.php",
            data: data,
            successCallback: (data) => {}
        });
    });

    // pubblica una recensione
    $("#publishReviewBtn").click(function() {
        if ($("#mark").val().trim() == "") {
            notifyError("Campo voto vuoto");
            return;
        }

        if ($("#body").val().trim() == "") {
            notifyError("Campo recensione vuoto");
            return;
        }

        createReview();
    });
});