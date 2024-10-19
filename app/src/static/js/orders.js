$(function() {
    $(".books").click(function(e) {
        if ($(e.target).hasClass("deleteBook")) {
            removeBookFromList($(e.target), 'delete_book_from_orders.php');
        }
    });
});