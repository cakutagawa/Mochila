function remove() {
    $(".rmv_item").click(function() {
        $(this).parents('tr').remove();
    });
}

$("#add_item").click(function() {
    var sample = "<tr><td><input type='number' name='p[w][]' class='form-control' autocomplete='false' required></td><td><input type='text' name='p[v][]' class='form-control' required></td><td><button type='button' class='btn btn-block btn-danger rmv_item'>x</button></td></tr>";
    $(".rmv_item").parents('tr:last').after(sample);
    remove();
});

remove();