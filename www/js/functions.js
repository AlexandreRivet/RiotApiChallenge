var REGION = 'br';
var START = 0;
var END = 9;



var CURRENT;
var TIMER_ID;
var STATS;

function getStats() {
 
    var region = REGION.toUpperCase();
            
    var div = '<div class="server" id="' + REGION + '">';
    div += '<div class="name">' + region + '</div>';
    div += '<div class="progression">?/?</div>';
    div += '</div>';

    $("#servers_list").append(div);
    
    $.getJSON("../resources/bilgewater_matchID/" + REGION + ".json", function(data) {
        
        STATS = {"number": data.length, "ids": data, "analysed": 0};
        
        TIMER_ID = setInterval(function() { getMatch() }, 15);        
        
    }).fail(function() {
        
        console.error("Can't find " + REGION + ".json"); 
        
    });
    
    
}

function getMatch() {
    
    console.log(CURRENT + " - " + (END + 1));
    
    if ( CURRENT == END + 1 ) {
        
        clearInterval(TIMER_ID);
        return;
        
    }
    
    var match_id = STATS.ids[CURRENT];
    
    getMatchStat(REGION, match_id);
    
    CURRENT++;   
    
}

function getMatchStat(region, match_id) {
 
    $.ajax({
       
        type: "POST",
        url: "functions.php",
        data: {"method": "getMatch", "region": region, "match_id": match_id}        
        
    }).done(function(result) {

        STATS.analysed++;
        var percent = STATS.analysed / (END - START + 1) * 100;

        $("#" + region + " .progression").html(STATS.analysed + "/" + (END - START + 1));

        if (percent > 99.9) {

            $("#" + region + " .progression").addClass("complete");

        }
              
    }).fail(function() {
        
        getMatchStat(region, match_id);
        
    });
    
}


$(document).ready(function() {
    
    $("#btn_start").click(function() {
    
        REGION = $("#select_region").val();
        START = parseInt($("#input_start").val());
        END = parseInt($("#input_end").val());
    
        CURRENT = START;
        
        getStats();
        
    });
        
});