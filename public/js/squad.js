
$( document ).ready(function() {
    /* Overall Part */
    let overall = 0;
    let titulaires = $('.player-in-squad');
    titulaires.each(function( index ) {
        var playerOverall = parseInt($( this ).find('.player-overall').text());
        overall += playerOverall;
        
    });
    overall = Math.round(overall / 7); 

    $('.team-overall').text("Global : "+overall);
});


//Choose a player
$('.player').click(function(){
    $(this).toggleClass("player-selected");
    //If player is titulaire add class player-selected on the player on the volley field image
    // if($(this).attr("data-position-squad") < 8){
    //     let positionNumber = $(this).attr("data-position-squad");
    //     let titulaireParentBlock = $("div[data-attribute='position-"+positionNumber+"']");
    //     let titulaire = titulaireParentBlock.find('.player-field');
    //     titulaire.toggleClass("player-selected");
         checkSelected();
    // }

})


function checkSelected(){
    if($('.player-selected').length == 2){
        let player1 = $('.player-selected')[0];
        let player1Id = player1.id;
        let player1SquadPosition =  $(player1).attr("data-position-squad");
        let player2 = $('.player-selected')[1];
        let player2Id = player2.id;
        let player2SquadPosition =  $(player2).attr("data-position-squad");
        console.log("id du joueur 1 : "+player1Id);
        console.log("SquadPosition joueur 1 : "+player1SquadPosition);
        console.log("id du joueur 2 : "+player2Id);
        console.log("SquadPosition joueur 2 : "+player2SquadPosition);
        var path = $("#swap").attr("data-path");
        $.ajax({
            url: path,
            type: "POST",
            dataType: "json",
                data: {
                    "player1": parseInt(player1Id),
                    "player2": parseInt(player2Id),
                    "player1SquadPosition": parseInt(player1SquadPosition),
                    "player2SquadPosition": parseInt(player2SquadPosition)
                },
                async: true,
                success: function (data) {
                    console.log(data);
                }
        });
    }
}


