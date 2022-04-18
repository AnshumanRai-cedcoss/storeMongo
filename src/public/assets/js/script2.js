$(document).ready(function() {
    $('body').on('click', '.modalBtn', function() {

        var id = $(this).data("id"); //fetching id of product to be added to cart
    
        $.ajax({
            'url': 'http://localhost:8080/products/quickView',
            'method': 'POST',
            'data': {
                'id': id
            },
            datatype: 'JSON'
        }).done(function(response) {
            responseData = $.parseJSON(response);
            if(responseData.variations.length > 0)
            {
            var variations = '<h3>  Varients  </h3><br>';
            for ($i in responseData.variations) {
                for ($j in responseData.variations[$i]) {
                    // console.log(responseData.Variations[$i][$j]);
                    variations += $j + `::` + responseData.variations[$i][$j] + `<br>`;

                }
                variations +=`<br>`;
            }
            $("#variations").html(variations);
        }
            var add = '<h3>Aditional</h3><br>';
            for ($i in responseData.additional) {
                add += $i+` :`+responseData.additional[$i]+`<br>`;
            }
            $("#additional").html(add);           
});
});
});