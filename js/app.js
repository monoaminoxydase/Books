$(function () {
 
    $('#bookList').on('click', $('.deleteBook'), function (e) {
        //jquery events on ajax load elements
        var deleteButton = $(e.target);
        var bookId = deleteButton.attr('data-id');
 
        $.ajax({
            url: 'api/books.php',
            type: 'DELETE',
            data: 'id=' + bookId,
        }).done(function (result) {
 
        }).fail(function () {
            console.log('Error');
        }); 
    });
 
    $.ajax({
        url: 'api/books.php', //bez data bo chcemy all books
        type: 'GET',
        dataType: 'json'
    }).done(function (result) {
 
        for (var i = 0; i < result.length; i++) {
 
            var book = JSON.parse(result[i]);
            
            var bookDiv = $('<div>').addClass('singleBook').html('<h3 data-id="' + book.id + '">' + book.title +
                '</h3><div class="description">' +
                '<button class="deleteBook" data-id="' + book.id + '">delete</button></div>');
            $('#bookList').append(bookDiv);
        }
    });
});