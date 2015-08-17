var CURRENT_REGION = null;
var REGIONS = [
    "BR",
    "EUNE",
    "EUW",
    "KR",
    "LAN",
    "LAS",
    "NA",
    "OCE",
    "RU",
    "TR"
];

var DATA = {};


$(document).ready(function() {
   
    // Load all stats files
    loadFile(0);
    
});

function loadFile(index) {
 
    if (index == 10) {
     
        return;
        
    }
    
    var region = REGIONS[index].toLowerCase();
    
    $.getJSON("resources/stats/" + region + ".json", function(data) {
        
        DATA[region] = data;
        
        loadFile(index + 1);
        
    }).fail(function() {
        
        console.log("Can't find " + region + ".json");
        
        loadFile(index + 1);
    
    });
    
}

function updateRegionContent() {
    
    if (DATA[CURRENT_REGION] == undefined || DATA[CURRENT_REGION] == null) {
    
        $("#region_stats").hide();
        
        $("#region_chosen").html(CURRENT_REGION.toUpperCase() + " : NO DATA");
        
        return;
        
    }
    
    var nbGames = DATA[CURRENT_REGION].info.number;
    
    $("#region_stats").show();
    
    $("#region_chosen").html(CURRENT_REGION.toUpperCase() + " : " + nbGames + " games analysed");
    
    // Black Market
    
    
    // Items
    
    
    // Champions
    var table = '<table id="champions_table_sort" class="table table-striped" data-sort-name="id" data-sort-order="desc">';
    table += '<thead><tr><th data-field="id" data-sortable="true">Champion</th><th>Pick rate</th><th>Ban rate</th><th>Win rate</th><th>Average KDA</th></tr></thead>';
    table += '<tbody>';
    
    for (var i = 0; i < DATA[CURRENT_REGION].champions.length; i++) {
        
        var champion = DATA[CURRENT_REGION].champions[i];
        var stats = champion["stats"];
        
        var pickrate = (stats["numberOfGamesPlayed"] / nbGames) * 100;
        var banrate = (stats["numberOfGamesBanned"] / nbGames) * 100;
        var winrate = stats["numberOfGamesWon"] / ((stats["numberOfGamesPlayed"] > 0) ? stats["numberOfGamesPlayed"] : 1) * 100;
        var kda = (stats["averageKDA"] != null) ? parseFloat(stats["averageKDA"]) : 0;
        
        table += '<tr>';
        
        table += '<td>' + champion["id"] + '</td>';
        table += '<td>' + pickrate.toFixed(2) + '%' + '</td>';
        table += '<td>' + banrate.toFixed(2) + '%</td>';
        table += '<td>' + ((winrate > 50) ? '<span class="green">' + winrate.toFixed(2) + '%</span>' : '<span class="red">' + winrate.toFixed(2) + '%</span>') + '</td>';
        table += '<td>' + kda.toFixed(2) + '</td>';
        
        table += '</tr>';
        
    }

    $("#champions_table").html(table);
    $("#champions_table_sort").DataTable({
        "paging": false        
    });
    
}