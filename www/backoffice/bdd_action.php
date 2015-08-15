<?php

    function getChampions() {

        include('env.php');
        
        $url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?champData=all&api_key='.$APIKEY;
        $content = file_get_contents($url);
        $json = json_decode($content, true);
        $data = $json["data"];
        
        foreach ($data as $champion) {
        
            $bdd->exec('INSERT INTO champion VALUES('.$champion["id"].', "'.$champion["name"].'", "'.$champion["title"].'", "'.$champion["lore"].'", "'.$champion["image"]["full"].'", "'.$champion["image"]["sprite"].'", "'.$champion["image"]["group"].'") ');
            
        }
        
    }


    function getItems() {
        
         include('env.php');
        
        $url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/item?itemListData=all&api_key='.$APIKEY;
        $content = file_get_contents($url);
        $json = json_decode($content, true);
        $data = $json["data"];
        
        foreach ($data as $item) {
        
            $bdd->exec('INSERT INTO item VALUES('.$item["id"].', "'.$item["sanitizedDescription"].'", "'.$item["plaintext"].'", "'.$item["name"].'", "'.$item["image"]["full"].'", "'.$item["image"]["sprite"].'", "'.$item["group"].'", '.$item["gold"]["total"].') ');
            
        }
        
    }

    getChampions();
    getItems();


?>