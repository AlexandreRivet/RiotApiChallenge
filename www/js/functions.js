var REGIONS;
var STATS = {};

function getAllGameStats()
{
    var regions = new Array();
    
    $.ajax({
        type: "POST",
        url: "functions.php",
        data: {method: "getRegions"}
        
    }).done(function(result) {
        
        REGIONS = JSON.parse(result);
        
        for (var i = 0; i < REGIONS.length; i++) {
         
            var region = REGIONS[i].toUpperCase();
            
            var div = '<div class="server" id="' + REGIONS[i] + '">';
            div += '<div class="name">' + region + '</div>';
            div += '<div class="progression">0%</div>';
            div += '</div>';
            
            $("#servers_list").append(div);
            
        }
        
        getRegionStats(0);
        
    });
    
}

function getRegionStats(index) 
{    
    var region = REGIONS[index];
    
    console.log(region + ' is currently being analysed.');
    
    if (region == undefined) {
     
        
        
        return;
        
    }
        
    $.getJSON("resources/bilgewater_matchID/" + region + ".json", function(data) {
        
        var numberOfGames = data.length;
        
        STATS[region] = {"number": numberOfGames, "id": data, "matches": {}, "analysed": 0};
        
        getMatchStats(index, 0);
        
    }).fail(function() {
      
        console.error("Can't find " + region + ".json");
        
    });
}

function getMatchStats(indexR, indexM) {
 
    var region = REGIONS[indexR];
    var match_id = STATS[region].id[indexM];
    
    $.ajax({
        
        type: "POST",
        url: "functions.php",
        dataType: "json",        
        data: {"method": "getMatch", "region": region, "match_id": match_id}
    
    }).done(function(result) {
        
        STATS[region].matches[match_id] = result;
        STATS[region].analysed++;
        
        var percent = STATS[region].analysed / STATS[region].number * 100;
        $("#" + region + " .progression").html(percent.toFixed(2) + "%");
        
        if (indexM === STATS[region].number) {
         
            getRegionStats(indexR + 1);
            
        }
        
        getMatchStats(indexR, indexM + 1);
        
    }).fail(function() {
        
        console.error("Fail on " + match_id);
        
        getMatchStats(indexR, indexM + 1);
        
    });
}

$(document).ready(function() {
   
    $("#btn_start").click(function() {
        
        getAllGameStats();
        
    });
    
});