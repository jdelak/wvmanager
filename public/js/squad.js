
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


//select a player
$('.player').click(function(){
    $(this).toggleClass("player-selected");
         checkSelected();
})

//Swap players if 2 players are selected
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
                    location.reload();
                }
        });
    }
}

//Get Info Player Modal
$(".player-in-squad").click(function(){
    let id = $(this).attr("data-id");
    const path = $("#playerInfo").attr("data-path");
    $.ajax({
        url: path,
        type: "POST",
        dataType: "json",
        data : {
            "playerId": id
        },
        async: true,
        success: function (data) {
            console.log(data);
            $('.modal-title').html(data.firstname+" "+data.lastname);
            $('.card-image').html( "<img src='/images/players/"+data.image+"' class='card-img' />");
            $('.age').html("Age : "+ data.age);
            $('.attack').html("Attack : "+ data.attack);
            $('.block').html("Block : "+ data.block);
            $('.dig').html("Dig : "+ data.dig);
            $('.passing').html("Passing : "+ data.passing);
            $('.serve').html("Serve : "+ data.serve);
            $('.training-count').html("Training Lasts : "+data.trainingCount);
            $('.sell').html("Sell for "+data.sellingPrice);
            $('#myModal').show();
            
        }
    })
})

//Close Modal
$(".close").click(function(){
    $('#myModal').hide();
})

