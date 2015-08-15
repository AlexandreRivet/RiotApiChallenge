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
    * Update BDD
    */
    function getMatch($region, $id) {
        
        include("env.php");
        
        $url = "https://".$region.$COMMON_URL.$region."/v2.2/match/".$id."?includeTimeline=true&api_key=".$APIKEY;
        $content = file_get_contents($url);
        
        if (!empty($content)) {
        
            $json = json_decode($content, true);

            setMatchInfo($json);
            setTeamInfo($json);
            setParticipantInfo($json);
            setEventInfo($json);
            
        } else {
         
            header('HTTP/1.0 404 Not found');
            exit;
            
        }
        
    }

    function setMatchInfo($json) {
       
        include("env.php");
        
        $match_req = "INSERT INTO `match` VALUES(".
                        $json["matchId"].", ".
                        $json["mapId"].", ".
                        $json["matchCreation"].", ".
                        $json["matchDuration"].", ".
                        "'".$json["matchMode"]."', ".
                        "'".$json["matchType"]."', ".
                        "'".$json["matchVersion"]."', ".
                        "'".$json["queueType"]."', ".
                        "'".$json["region"]."', ".
                        "'".$json["season"]."'".
                    ")";
                
        $bdd->exec($match_req);
        
    }

    function setTeamInfo($json) {
        
        include("env.php");
        
        $teams = $json["teams"];
        $numberOfTeams = count($teams);
        
        for($i = 0; $i < $numberOfTeams; $i++) {
        
            $team = $teams[$i];
            $team_req = "INSERT INTO `team` VALUES(".
                            "NULL, ".
                            $team["teamId"].", ".
                            $json["matchId"].", ".
                            $team["baronKills"].", ".
                            $team["dragonKills"].", ".
                            (($team["firstBaron"] == true) ? "1" : "0").", ".
                            (($team["firstBlood"] == true) ? "1" : "0").", ".
                            (($team["firstDragon"] == true) ? "1" : "0").", ".
                            (($team["firstInhibitor"] == true) ? "1" : "0").", ".
                            (($team["firstTower"] == true) ? "1" : "0").", ".
                            $team["towerKills"].", ".
                            $team["inhibitorKills"].", ".
                            $team["vilemawKills"].", ".
                            (($team["winner"] == true) ? "1" : "0").
                        ")";
            
            $bdd->exec($team_req);
            
            setBannedChampionInfo($json, $team);
            
        }
        
    }

    function setParticipantInfo($json) {
        
        include("env.php");
        
        $participants = $json["participants"];
        $numberOfParticipants = count($participants);
        
        for($i = 0; $i < $numberOfParticipants; $i++) {
        
            $participant = $participants[$i];
            $participant_req = "INSERT INTO `participant` VALUES(".
                                    $participant["participantId"].", ".
                                    $json["matchId"].", ".
                                    $participant["championId"].", ".
                                    $participant["spell1Id"].", ".
                                    $participant["spell2Id"].", ".
                                    $participant["teamId"].
                                ")";                
                
            $bdd->exec($participant_req);
            
            setStatInfo($json, $participant);
            
        }
        
    }

    function setStatInfo($match, $json) {
        
        include("env.php");
        
        $stats = $json["stats"];
        
        $stats_req = "INSERT INTO `stats` VALUES(".
                        "NULL, ".
                        $json["participantId"].", ".
                        $match["matchId"].", ".
                        $stats["champLevel"].", ".
                        $stats["item0"].", ".
                        $stats["item1"].", ".
                        $stats["item2"].", ".
                        $stats["item3"].", ".
                        $stats["item4"].", ".
                        $stats["item5"].", ".
                        $stats["item6"].", ".
                        $stats["kills"].", ".
                        $stats["doubleKills"].", ".
                        $stats["tripleKills"].", ".
                        $stats["quadraKills"].", ".
                        $stats["pentaKills"].", ".
                        $stats["deaths"].", ".
                        $stats["assists"].", ".
                        $stats["wardsPlaced"].", ".
                        $stats["wardsKilled"].
                    ")";

        $bdd->exec($stats_req);
        
    }

    function setBannedChampionInfo($match, $team) {
        
        include("env.php");
        
        $bans = $team["bans"];
        $numberOfBans = count($bans);
        
        for ($i = 0; $i < $numberOfBans; $i++) {
            
            $ban = $bans[$i];
            
            $ban_req = "INSERT INTO `banned_champion` VALUES(".
                            "NULL, ".
                            $match["matchId"].", ".
                            $team["teamId"].", ".
                            $ban["championId"].", ".
                            $ban["pickTurn"].
                        ")";
            
            $bdd->exec($ban_req);
            
        }
        
    }

    function setEventInfo($json) {
        
        include("env.php");
        
        $frames = $json["timeline"]["frames"];
        $numberOfFrames = count($frames);
        
        for ($i = 0; $i < $numberOfFrames; $i++) {
            
            $frame = $frames[$i];
            
            if (!isset($frame["events"])) {
                
                continue;
                
            }
            
            $events = $frame["events"];
            $numberOfEvents = count($events);
            
            for ($j = 0; $j < $numberOfEvents; $j++) {
             
                $event = $events[$j];
                
                if ($event["eventType"] != "ITEM_PURCHASED") {
                 
                    continue;
                    
                }
                
                $event_req = "INSERT INTO `event` VALUES(".
                                "NULL, ".
                                "'".$event["eventType"]."', ".
                                $event["itemId"].", ".
                                $event["participantId"].", ".
                                $event["timestamp"].", ".
                                $json["matchId"].
                            ")";
                
                $bdd->exec($event_req);
                
            }
            
        }
        
    }

?>