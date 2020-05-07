
$( document ).ready(function() {
    /* Overall Part */
    let overall = 0;
    let titulaires = $('.player');
    titulaires.each(function( index ) {
        var playerOverall = parseInt($( this ).find('.player-overall').text());
        overall += playerOverall;
        
    });
    overall = Math.round(overall / 12); 
    $('.team-overall').text("Global : "+overall);

    var player = $(".player-in-squad");
    var mainCanvas = $("#squadPage");
    //drag and drop part
    player.draggable({
        containment: mainCanvas,
        helper: "clone",

        start: function () {
            $(this).css({
                opacity: 0
            });

            $(".player").css("z-index", "0");
        },

        stop: function () {
            $(this).css({
                opacity: 1
            });
        }
    });

    player.droppable({
        accept: player,

        drop: function (event, ui) {
            var draggable = ui.draggable;
            let player1Id = draggable.attr("data-id");
            let player1SquadPosition =  $(draggable).attr("data-position-squad");
            var droppable = $(this);
            let player2Id = droppable.attr("data-id");
            let player2SquadPosition =  $(droppable).attr("data-position-squad");
            // var dragPos = draggable.position();
            // var dropPos = droppable.position();

            // draggable.css({
            //     left: dropPos.left + "px",
            //     top: dropPos.top + "px",
            //     "z-index": 20
            // });

            // droppable.css("z-index", 10).animate({
            //     left: dragPos.left,
            //     top: dragPos.top
            // });
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
    });
});

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
            $('.overall').html(data.overall);
            $('.attack').html("Attack : "+ data.attack);
            $('.block').html("Block : "+ data.block);
            $('.dig').html("Dig : "+ data.dig);
            $('.passing').html("Passing : "+ data.passing);
            $('.serve').html("Serve : "+ data.serve);
            $('.training-count').html("Training Lasts : "+data.trainingCount);
            $('.sell-button').attr("data-player-id", data.id);
            $('.sell').html("Sell for "+data.sellingPrice);
            $('#myModal').show();
            
        }
    })
})

//Close Modal
$(".close").click(function(){
    $('#myModal').hide();
})

//Selling Player
$(".sell-button").click(function(){
    let id = $(this).attr("data-player-id");
    const path = $("#playerSell").attr("data-path");
    $.ajax({
        url: path,
        type: "POST",
        dataType: "text",
        data : {
            "playerId": id
        },
        async: true,
        success: function (data) {
            alert(data);
        }
    })

})