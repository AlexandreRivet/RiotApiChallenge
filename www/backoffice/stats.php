<?php

    include("env.php");

    $region = isset($_GET["region"]) ? $_GET["region"] : "br";

    function generateStats() {
     
        global $bdd, $region;
        
        $stats = array();
        
        /*** GLOBAL INFO ***/
        
        $stats["info"]["number"] = 10000;
        
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
        
        
        // echo '<pre>';
        // print_r($stats);
        
        $fp = fopen($region.'.json', 'w');
        fwrite($fp, json_encode($stats));
        fclose($fp);
        
    }

    function getNumberOfGamesPlayed(&$arr) {
     
        global $bdd;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM participant WHERE championID = :championID');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesPlayed"] = $statement->fetchAll()[0][0];            
            
        }
        
    }

    function getNumberOfGamesBanned(&$arr) {
        
        global $bdd;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM banned_champion WHERE championID = :championID');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesBanned"] = $statement->fetchAll()[0][0];            
            
        }
           
    }

    function getNumberOfGamesWon(&$arr) {
        
        global $bdd;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM participant
                                        INNER JOIN team
                                        WHERE participant.matchID = team.matchID
                                        AND participant.teamID = team.teamID
                                        AND participant.championID = :championID
                                        AND team.winner = 1');
            $statement->execute(array(':championID' => $id));
            
            $arr[$i]["stats"]["numberOfGamesWon"] = $statement->fetchAll()[0][0];            
            
        }
        
    }

    function getStats(&$arr) {
        
        global $bdd;
        
        $count = count($arr);
        
        for ($i = 0; $i < $count; $i++) {
            
            $id = $arr[$i]["id"];
        
            $statement = $bdd->prepare('SELECT SUM(stats.kills), SUM(stats.deaths), SUM(stats.assists), 
                                        SUM(stats.doubleKills), SUM(stats.tripleKills), SUM(stats.quadraKills), 
                                        SUM(stats.pentaKills), SUM(stats.wardsPlaced), SUM(stats.wardsKilled),
                                        MAX(stats.kills), MAX(stats.deaths), MAX(stats.assists), ((AVG(stats.kills) + AVG(stats.assists)) / AVG(stats.deaths))
                                        FROM stats
                                        INNER JOIN participant
                                        WHERE stats.matchID = participant.matchID
                                        AND stats.participantID = participant.id
                                        AND participant.championID = :championID');
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
                                        WHERE stats.matchID = participant.matchID
                                        AND stats.participantID = participant.id
                                        AND participant.championID = :championID');
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


    function getKrakensSpent(&$arr) {
        
        global $bdd;
        
        $krakens = 0;
        
        $step = 10000;
        $offset = 0;
        $numberOfItems = 0;
        do {
            
            $statement = $bdd->prepare('SELECT * FROM event
                                            INNER JOIN item
                                            WHERE event.itemID = item.id
                                            AND item.group LIKE "BWMerc%"
                                            LIMIT '.$offset.', '.$step);
        
            $statement->execute();
            $data = $statement->fetchAll();
            
            $numberOfItems = count($data);
        
            for ($i = 0; $i < $numberOfItems; $i++) {
         
                $item = $data[$i];
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
            
            $offset += $step;
            
        } while($numberOfItems != 0);
        
        $arr["numberKrakens"] = $krakens;
        
    }


/*
    function calcPickRate() {
     
        echo "*** PICKRATE ***<br>";
        
        include("env.php");
        
        $statement = $bdd->prepare('SELECT * FROM champion'); 
		$statement->execute();
		$data = $statement->fetchAll();
        
        $numberOfChampions = count($data);
    
        $statement = $bdd->prepare('SELECT count(*) FROM `match`');
        $statement->execute();
        $numberOfGames = $statement->fetchAll()[0][0];
        
        echo $numberOfGames." games analysed.<br>";
        
        for ($i = 0; $i < $numberOfChampions; $i++) {
         
            $champion = $data[$i];
            $id = $champion["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM participant WHERE championID = :championID');
            $statement->execute(array(':championID' => $id));
            $numberOfThisChampion = $statement->fetchAll()[0][0];
            
            $percent = round((($numberOfThisChampion / $numberOfGames) * 100), 2);
            
            echo $champion["name"]." : ".$percent."%<br>";
            
        }
        
    }

    function calcBanRate() {
        
        echo "*** BANRATE ***<br>";
        
        include("env.php");
        
        $statement = $bdd->prepare('SELECT * FROM champion'); 
		$statement->execute();
		$data = $statement->fetchAll();
        
        $numberOfChampions = count($data);
    
        $statement = $bdd->prepare('SELECT count(*) FROM `match`');
        $statement->execute();
        $numberOfGames = $statement->fetchAll()[0][0];
        
        for ($i = 0; $i < $numberOfChampions; $i++) {
         
            $champion = $data[$i];
            $id = $champion["id"];
            
            $statement = $bdd->prepare('SELECT count(*) FROM banned_champion WHERE championID = :championID');
            $statement->execute(array(':championID' => $id));
            $numberOfThisChampion = $statement->fetchAll()[0][0];
            
            echo $numberOfThisChampion."<br>";
            
            $percent = round((($numberOfThisChampion / $numberOfGames) * 100), 2);
            
            echo $champion["name"]." : ".$percent."%<br>";
            
        }
        
    }

    function calcWinRate() {
        
        echo "*** WINRATE ***<br>";
        
        include("env.php");
        
        $statement = $bdd->prepare('SELECT * FROM champion'); 
		$statement->execute();
		$data = $statement->fetchAll();
        
        $numberOfChampions = count($data);
    
        for ($i = 0; $i < $numberOfChampions; $i++) {
         
            $champion = $data[$i];
            $id = $champion["id"];
            
            /* Picked *
            $statement = $bdd->prepare('SELECT count(*) FROM participant WHERE championID = :championID');
            $statement->execute(array(':championID' => $id));
            $numberOfThisChampionPicked = $statement->fetchAll()[0][0];
            
            $winner = 0;
            /* Won with *
            $statement = $bdd->prepare('SELECT count(*) FROM participant
                                        INNER JOIN team
                                        WHERE participant.matchID = team.matchID
                                        AND participant.teamID = team.teamID
                                        AND participant.championID = :championID
                                        AND team.winner = 1');
            $statement->execute(array(':championID' => $id));
            $numberOfThisChampionWon = $statement->fetchAll()[0][0];
            
            echo $numberOfThisChampionPicked." - ".$numberOfThisChampionWon."<br>";
            
            $percent = ($numberOfThisChampionPicked != 0) ? ($numberOfThisChampionWon / $numberOfThisChampionPicked) * 100 : 0;
            $percent = round($percent, 2);
            
            echo $champion["name"]." : ".$percent."%<br>";
            
        }
        
    }

    function calcKrakensSpent() {
     
        echo "*** KRAKENS ***<br>";
        
        include("env.php");
        
        $krakens = 0;
        
        $step = 2000;
        $offset = 0;
        $numberOfItems = 0;
        do {
            
            $statement = $bdd->prepare('SELECT * FROM event
                                            INNER JOIN item
                                            WHERE event.itemID = item.id
                                            AND item.group LIKE "BWMerc%"
                                            LIMIT '.$offset.', '.$step);
        
            $statement->execute();
            $data = $statement->fetchAll();
            
            $numberOfItems = count($data);
        
            for ($i = 0; $i < $numberOfItems; $i++) {
         
                $item = $data[$i];
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
            
            $offset += $step;
            
        } while($numberOfItems != 0);
        
        echo $krakens." krakens spent.";
        
    }
*/
    generateStats();

    /*
    calcPickRate();
    echo "******************************<br>";
    calcBanRate();
    echo "******************************<br>";
    calcWinRate();
    echo "******************************<br>";*/
    // calcKrakensSpent();


?>