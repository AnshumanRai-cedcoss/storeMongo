var count = 0;
var nm = ``;
$("body").on("click", "#show", function () {
  displayInput();
});
$("body").on("click", "#deleteField", function (e) {
  $("#div-" + count).remove();
  count--;
});

function displayInput() {
  nm = `<div id = "div-${++count}">
    <input  id="label" name="label-${count}" placeholder="label" style="width: 80px;">:
    <input  id="value"  name="value-${count}" placeholder="value" style="width: 200px;">
    <br></div>`;

  $("#extraFields").append(nm);
}

//--------------------------------------------Variations-----------------------------------------//
var c = 0;
var display = ``;
var k = 0;
$("body").on("click", "#showVariations", function () {
  $(".price-varient").show();
  displayVariations(1);
  k = 1;
});
$("body").on("click", "#deleteVariations", function (e) {
  $("#divVar-" + c).remove();
  c--;
});
$("body").on("click", "#addBtn", function (e) {
    displayMore($(this).data("pid"));
});

function displayVariations() { 
  display = `<div id = "divVar-${++c}"> 
    <div>
    <input  id="label" name="labelV-${c}-${1}" placeholder="name" style="width: 80px;">:
    <input  id="value"  name="valueV-${c}-${1}" placeholder="value" style="width: 200px;">
    <button type="button" id="addBtn" data-pid=${c}>+</button></div>
    <div class="divS-${c}"></div>
    <input  id="value"  name="priceV-${c}" placeholder="price" style="width: 80px;">
    <br></div>`;

  $("#variationsField").append(display);
}
function displayMore(id) {
  k++;
  display = `
    <input  id="label" name="labelV-${id}-${k}" placeholder="name" style="width: 80px;">:
    <input  id="value"  name="valueV-${id}-${k}" placeholder="value" style="width: 200px;">
    <button type="button" id="addBtn"  data-pid=${id}>+</button>
    <br>`;

  $(".divS-" + id).append(display);
}
