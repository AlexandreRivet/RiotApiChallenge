<?php

    $method = $_POST['method'];

    if ($method == "getRegions") {
        
        getRegions();
        
    } else if ($method == "getMatch") {
     
        getMatch($_POST['region'], $_POST['match_id']);
        
    }

    /**
    * Function returns all regions analysed
    * Scan directory
    * @return Array with regions
    */
    function getRegions() {
        
        $dir = 'resources/bilgewater_matchID';
        $files = array_diff(scandir($dir), array('..', '.'));
        $regions = array();
        
        foreach ($files as $file) {
            
            array_push($regions, strtolower(explode(".", $file)[0]));
            
        }
        
        echo json_encode($regions);
        
    }

    /**
    * Function returns stats for one game
    * Launch a request to RIOT API
    * @return json object with stats
    */
    function getMatch($region, $id) {
        
        include("env.php");        
        
        $url = "https://".$region.$COMMON_URL.$region."/v2.2/match/".$id."?api_key=".$APIKEY;
        $content = file_get_contents($url);
        
        echo $content;
        
    }

?>