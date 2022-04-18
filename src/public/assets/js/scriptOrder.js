$(document).ready(function () {
  $("body").on("change", ".productSelected", function () {
    var id = $(this).find(":selected").attr("data-id");

    $.ajax({
      url: "http://localhost:8080/orders/getVariations",
      method: "POST",
      data: {
        id: id,
      },
      datatype: "JSON",
    }).done(function (response) {
      responseData = $.parseJSON(response);
      console.log(responseData);
      if (responseData.variations.length > 0) {
        var variations = `<select name="varient" id="variationSelected" class="w-100 p-2 text-center">
            <option>------------------- Select Variations ----------------------</option>`;
        for (i in responseData.variations) {
          variations += `<option>`;
          for (j in responseData.variations[i]) {
            if(j != 'price')
            variations += j + ":" + responseData.variations[i][j] + " "; 
          }
          variations += "</option>";
        }
        variations += `</select>`;
        $("#displayVariations").html(variations);
        $("#price").val(responseData.variations[i]['price']);
      }
    });
  });
  // $("body").on("change", "#variationSelected", function () {
  //   var value = $(this).find(":selected").val();
  //   console.log(value);
  // });

  $("body").on("change", ".dateSelected", function () {
    
    var value = $(this).find(":selected").val();
    if(value == "Custom")
    {
      $('#customDiv').show();
    }
  });



  $("body").on("change", ".statusSelected", function () {
    var id = $(this).find(":selected").attr("data-id");
     var value = $(this).find(":selected").val();
     console.log(value);
    $.ajax({
      url: "http://localhost:8080/orders/changeStatus",
      method: "POST",
      data: {
        id: id,
        value : value
      },
      datatype: "JSON",
    }).done(function (response) {
      window.location.replace("list");
    });
  });
});
