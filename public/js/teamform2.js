var currentIndex = 0,
items = $('#container-slider div'),
itemAmt = items.length;
var item = $('#container-slider div').eq(currentIndex);
item.css('display','inline-block');
item.addClass('selected');
$('#teamImage').val(item.attr('data-val'));

function cycleItems() {
    var item = $('#container-slider div').eq(currentIndex);
    items.hide();
    items.removeClass('selected');
    item.css('display','inline-block');
    item.addClass('selected');
    $('#teamImage').val(item.attr('data-val'));
}


$('.next').click(function() {
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();

});

$('.prev').click(function() {
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
  }
  cycleItems();
});


