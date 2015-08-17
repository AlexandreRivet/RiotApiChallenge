<?php

    include("env.php");

    $region = isset($_GET["region"]) ? $_GET["region"] : "br";

    /**
    * Function generate file with all stats for one region
    */
    function generateStats() {
     
        global $bdd, $region;
        
        $stats = array();
        
        /*** GLOBAL INFO ***/
        $statement = $bdd->prepare('SELECT count(*) FROM `match`
                                        WHERE region = "'.$region.'"'); 
		$statement->execute();
		$data = $statement->fetchAll()[0][0];
        
        $stats["info"]["number"] = $data;
        
        /*** CHAMPION INFO ***/
        $statement = $bdd->prepare('SELECT * FROM champion'); 
		$statement->execute();
		$data = $statement->fetchAll();
        
        $numberOfChampions = count($data);
        
        for ($i = 0; $i < $numberOfChampions; $i++) {
         
            $champion = $data[$i];
            
            $stats["champions"][$i] = [
                "id" => $champion["id"],
                "stats" => array(), 
            ];
            
        }
        
        getNumberOfGamesPlayed($stats["champions"]);
        getNumberOfGamesBanned($stats["champions"]);
        getNumberOfGamesWon($stats["champions"]);
        getStats($stats["champions"]);
        
        /*** BLACK MARKET INFO ***/
        $stats["bwmerc"] = array();
        getKrakensSpent($stats["bwmerc"]);
        getBrawlersStats($stats["bwmerc"]);
        getBestCompositionOfBrawlers($stats["bwmerc"]);
        
        /*** ITEMS INFO ***/
        $stats["items"] = array();
        getItemsStats($stats["items"]);
        
        echo '<pre>';
        print_r($stats);
        
        $fp = fopen($region.'.json', 'w');
        fwrite($fp, json_encode($stats));
        fclose($fp);
        
    }

    /**
    * Function get number of games played for each champion
    */
    function getNumberOfGamesPlayed(&$arr) {
     
        global $bdd, $region;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM participant
                                        INNER JOIN `match` 
                                        WHERE championID = :championID
                                        AND participant.matchID = match.id
                                        AND match.region =  "'.$region.'"');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesPlayed"] = $statement->fetchAll()[0][0];            
            
        }
        
    }

    /**
    * Function get number of games banned for each champion
    */
    function getNumberOfGamesBanned(&$arr) {
        
        global $bdd, $region;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM banned_champion 
                                        INNER JOIN `match`
                                        WHERE championID = :championID
                                        AND banned_champion.matchID = match.id
                                        AND match.region = "'.$region.'"');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesBanned"] = $statement->fetchAll()[0][0];            
            
        }
           
    }

    /**
    * Function get number of games won for each champion
    */
    function getNumberOfGamesWon(&$arr) {
        
        global $bdd, $region;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM participant
                                        INNER JOIN team
                                        INNER JOIN `match`
                                        WHERE participant.matchID = team.matchID
                                        AND participant.matchID = match.id
                                        AND participant.teamID = team.teamID
                                        AND participant.championID = :championID
                                        AND team.winner = 1
                                        AND match.region = "'.$region.'"');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesWon"] = $statement->fetchAll()[0][0];            
            
        }
        
    }

    /**
    * Function get stats for each champion
    */
    function getStats(&$arr) {
        
        global $bdd, $region;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
        
            $statement = $bdd->prepare('SELECT SUM(stats.kills), SUM(stats.deaths), SUM(stats.assists), 
                                        SUM(stats.doubleKills), SUM(stats.tripleKills), SUM(stats.quadraKills), 
                                        SUM(stats.pentaKills), SUM(stats.wardsPlaced), SUM(stats.wardsKilled),
                                        MAX(stats.kills), MAX(stats.deaths), MAX(stats.assists), ((AVG(stats.kills) + AVG(stats.assists)) / AVG(stats.deaths))
                                        FROM stats
                                        INNER JOIN participant
                                        INNER JOIN `match`
                                        WHERE stats.matchID = participant.matchID
                                        AND participant.matchID = match.id
                                        AND stats.participantID = participant.id
                                        AND participant.championID = :championID
                                        AND match.region = "'.$region.'"');
            $statement->execute(array(':championID' => $id));
            
            $data = $statement->fetchAll()[0];
        
            $arr[$i]["stats"]["kills"] = $data[0];
            $arr[$i]["stats"]["deaths"] = $data[1];
            $arr[$i]["stats"]["assists"] = $data[2];
            $arr[$i]["stats"]["doubleKills"] = $data[3];
            $arr[$i]["stats"]["tripleKills"] = $data[4];
            $arr[$i]["stats"]["quadraKills"] = $data[5];
            $arr[$i]["stats"]["pentaKills"] = $data[6];
            $arr[$i]["stats"]["wardsPlaced"] = $data[7];
            $arr[$i]["stats"]["wardsKilled"] = $data[8];
            $arr[$i]["stats"]["highestKills"] = $data[9];
            $arr[$i]["stats"]["highestDeaths"] = $data[10];
            $arr[$i]["stats"]["highestAssists"] = $data[11];
            $arr[$i]["stats"]["averageKDA"] = $data[12];
            
            $arr[$i]["stats"]["items"] = array();
            
            $statement = $bdd->prepare('SELECT item0, item1, item2, item3, item4, item5, item6
                                        FROM stats
                                        INNER JOIN participant
                                        INNER JOIN `match`
                                        WHERE stats.matchID = participant.matchID
                                        AND participant.matchID = match.id
                                        AND stats.participantID = participant.id
                                        AND participant.championID = :championID
                                        AND match.region = "'.$region.'"');
            $statement->execute(array(':championID' => $id));
            $data = $statement->fetchAll();
            $countData = count($data);
            
            $items = array();
            
            for ($j = 0; $j < $countData; $j++) {
             
                for ($k = 0; $k < 7; $k++) {
                 
                    $itemID = $data[$j][$k];
                    
                    if (!isset($items[$itemID])) {
                        
                        $items[$itemID] = 0;
                        
                    }
                    
                    $items[$itemID]++;
                    
                }
                
            }
            
            arsort($items);
            
            $counter = 0;
            foreach ($items as $key => $value) {
             
                if ($key == 0) {
                    
                    continue;
                    
                }
                
                array_push($arr[$i]["stats"]["items"], $key);
                
                $counter++;
                
                if($counter == 7) {
                 
                    break;
                    
                }
        
            }
            
        }        
        
    }

    /**
    * Function get number of krakens spent
    */
    function getKrakensSpent(&$arr) {
        
        global $bdd, $region;
        
        $statement = $bdd->prepare('SELECT id from `match` WHERE region = "'.$region.'"');
        
        $statement->execute();
        $data = $statement->fetchAll();
        
        $numberOfGames = count($data);
        
        $krakens = 0;
        
        for ($i = 0; $i < $numberOfGames; $i++) {
    
            $id = $data[$i]["id"];
            
            $statement = $bdd->prepare('SELECT * FROM event
                                            INNER JOIN item
                                            WHERE event.itemID = item.id
                                            AND event.matchID = '.$id.'
                                            AND item.group LIKE "BWMerc%"');
        
            $statement->execute();
            $items = $statement->fetchAll();

            $numberOfItems = count($items);
        
            for ($j = 0; $j < $numberOfItems; $j++) {
         
                $item = $items[$j];
                $group = $item["group"];
                
                if (strlen($group) == 8) {
                    
                    $krakens += 5;
                    
                } else {
                    
                    $level = intval(substr($group, -1));
                    
                    if ($level == 1) {
                        
                        $krakens += 5;
                        
                    } else {
                        
                        $krakens += 2 * ($level - 1) * 5;
                        
                    }
                    
                }
                
            }
            
            
            
        }
        
        $arr["numberKrakens"] = $krakens;
        
    }

    /**
    * Function get stats for brawlers
    */
    function getBrawlersStats(&$arr) {
        
        global $bdd, $region;
        
        $arr["brawlers"] = array();
        
        // Get Razorfin
        getBrawlerStats($arr, 3611);
        
        // Get Ironback
        getBrawlerStats($arr, 3612);
        
        // Get Plundercrab
        getBrawlerStats($arr, 3613);
        
        // Get Ocklepod
        getBrawlerStats($arr, 3614);        
        
    }

    /**
    * Function get stats for one brawler with his id
    */
    function getBrawlerStats(&$arr, $id) {
    
        global $bdd, $region;
        
        $statement = $bdd->prepare('SELECT count(*) FROM event
                                        INNER JOIN `match`
                                        WHERE event.itemID = '.$id.'
                                        AND event.matchID = match.id
                                        AND match.region = "'.$region.'"');
        
        $statement->execute();
        $number = $statement->fetchAll()[0][0];
        
        $arr["brawlers"][$id] = array();
        $arr["brawlers"][$id]["bought"] = $number;        
        
    }

    /**
    * Function get best composition of brawlers
    */
    function getBestCompositionOfBrawlers(&$arr) {
     
        global $bdd, $region;
        
        $compositions = array();
        
        $statement = $bdd->prepare('SELECT id from `match`
                                        WHERE region = "'.$region.'"');
        
        $statement->execute();
        $data = $statement->fetchAll();
        
        $numberOfGames = count($data);
        
        $combinations = array();
        
        for ($i = 0; $i < $numberOfGames; $i++) {
    
            $array_tmpB = array();
            $array_tmpR = array();
            
            for ($j = 1; $j <= 4; $j++) {
        
                $itemID = 3610 + $j;
            
                // Blue
                $statement = $bdd->prepare('SELECT count(event.itemID) FROM event
                                                WHERE event.itemID = '.$itemID.'
                                                AND event.matchID = '.$data[$i]["id"].'
                                                AND event.participantID < 6');
                $statement->execute();
                $items = $statement->fetchAll();
                
                $nbItem = $items[0][0];
                
                for ($k = 0; $k < $nbItem; $k++) {
                
                    array_push($array_tmpB, $j);
                    
                }
                
                // Red
                $statement = $bdd->prepare('SELECT count(event.itemID) FROM event
                                                WHERE event.itemID = '.$itemID.'
                                                AND event.matchID = '.$data[$i]["id"].'
                                                AND event.participantID >= 6');
                $statement->execute();
                $items = $statement->fetchAll();
                
                $nbItem = $items[0][0];
                
                for ($k = 0; $k < $nbItem; $k++) {
                
                    array_push($array_tmpR, $j);
                    
                }
                
            }

            sort($array_tmpB);
            sort($array_tmpR);
            $combinationB = implode($array_tmpB);
            $combinationR = implode($array_tmpR);
    
            if (!isset($combinations[$combinationB])) {
             
                $combinations[$combinationB] = 0;
                
            }
            
            $combinations[$combinationB]++;
            
            if (!isset($combinations[$combinationR])) {
             
                $combinations[$combinationR] = 0;
                
            }
            
            $combinations[$combinationR]++;
            
        }
        
        arsort($combinations);
        
        $firstKey = array_keys($combinations)[0];
        
        $arr["compositions"] = array();
        $arr["compositions"]["mostPopular"] = array();
        
        $arr["compositions"]["mostPopular"]["setup"] = $firstKey;
        $arr["compositions"]["mostPopular"]["number"] = $combinations[$firstKey];
        
        $arr["compositions"]["noBrawlers"] = $combinations[null];
        
    }

    /**
    * Function get stats for items
    */
    function getItemsStats(&$arr) {
        
        global $bdd, $region;
        
        $statement = $bdd->prepare('SELECT id from `match` WHERE region = "'.$region.'"');
        
        $statement->execute();
        $data = $statement->fetchAll();
        
        $numberOfGames = count($data);
        
        $items = array();
        
        for ($i = 0; $i < $numberOfGames; $i++) {
    
            $id = $data[$i]["id"];
            
            $statement = $bdd->prepare('SELECT item0, item1, item2, item3, item4, item5, item6
                                        FROM stats
                                        WHERE stats.matchID = '.$id);
            
            $statement->execute();
            $result = $statement->fetchAll();
            
            $countData = count($result);
            
            for ($j = 0; $j < $countData; $j++) {
             
                for ($k = 0; $k < 7; $k++) {
                    
                    $itemID = $result[$j][$k];
                    
                    if (!isset($items[$itemID])) {
                        
                        $items[$itemID] = 0;
                        
                    }
                    
                    $items[$itemID]++;
                    
                }
                
            }
        }
        
        arsort($items);
        
        $arr = $items;
        
    }

    // Launch the process
    generateStats();

?>