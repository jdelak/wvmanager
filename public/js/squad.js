/* Overall Part */
var overall = 0;
var titulaires = $('.player-in-squad');
titulaires.each(function( index ) {
    var playerOverall = parseInt($( this ).find('.player-overall').text());
    console.log( index + ": " + playerOverall );
    overall += playerOverall;
    
});
overall = Math.round(overall / 7); 
console.log(overall);

$('.team-overall').text("Global : "+overall);


//Choose a player
$('.player').click(function(){
    $(this).addClass("player-selected");

})