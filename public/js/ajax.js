function AddCart(id) {
    $.ajax({
        url: 'add-to-cart/' + id,
        type: 'GET',
    }).done(function(response) {
        $("#change-item-cart").empty();
        $("#change-item-cart").html(response);
        alertify.success('Item added successfully');
    });
}