let $draggable = null;
let isDragging = false;
const DRAG_ADJUST = 150;

function _isMouseOverCart(mouseX, mouseY) {
    let cart = $(".cart");
    let cartCenter = {
        y: cart.offset().top + 46,
        x: cart.offset().left + 46
    };
    let spaceX = 150;
    let spaceY = spaceX;

    let isMouseOverCart = mouseX <= (cartCenter.x + spaceX);
    isMouseOverCart = isMouseOverCart && mouseX >= (cartCenter.x - spaceX);
    isMouseOverCart = isMouseOverCart && mouseY <= (cartCenter.y + spaceY);
    isMouseOverCart = isMouseOverCart && mouseY >= (cartCenter.y - spaceY);

    return isMouseOverCart;
}

function _handleMouseup(event) {
    if (isDragging) {
        isDragging = false;
        let bookId = $draggable.find(".card__id").text().trim()
        $(".cart").removeClass("is-dragging");
        $draggable.removeClass("is-dragging");
        $draggable.css({
            "left": "0px",
            "top": "0px"
        });
        $draggable.removeClass("is-hovering-cart");
        $draggable = null;

        if (_isMouseOverCart(event.pageX, event.pageY)) {
            sendJSONData({
                url: "add_book_to_cart.php",
                data: { bookId: bookId, quantity: 1 },
                successCallback: (data) => {}
            });
        }
    }
}

function _handleMousedown(e) {
    $draggable = $(this).parent();

    if ($draggable.hasClass("card")) {
        isDragging = true;
        $(".cart").addClass("is-dragging");
        $draggable.addClass("is-dragging");
        $draggable.css({
            "left": e.pageX - DRAG_ADJUST + "px",
            "top": e.pageY - DRAG_ADJUST + "px"
        });
    }

    return false;
}

function _handleMousemove(event) {
    if (isDragging) {
        $draggable.css({
            "left": event.pageX - DRAG_ADJUST + "px",
            "top": event.pageY - DRAG_ADJUST + "px"
        });

        if (_isMouseOverCart(event.pageX, event.pageY)) {
            $draggable.addClass("is-hovering-cart");
        } else {
            $draggable.removeClass("is-hovering-cart");
        }
    }
}

// MAIN
$(function() {
    // imposta il drag-n-drop delle card
    $(".card__drag-area").on("mousedown", _handleMousedown);
    $("body").on("mouseup", _handleMouseup);
    $("body").on("mousemove", _handleMousemove);

    // effettua una ricerca dinamica fra le card
    $("#title").on("keyup paste", function(e) {
        let input = $(this).val().trim();

        if (input != "") {
            $(".card").hide();

            $(".card__description__title").each(function() {
                if ($(this).text().toLowerCase().includes(input.toLowerCase())) {
                    $(this).parent().parent().show();
                }
            });
        } else {
            $(".card").show();
        }
    });
});