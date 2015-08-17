/* Biglewater schema for challenge */
CREATE SCHEMA `bilgewater_eune`;

USE `bilgewater_eune`;

/* champion table */
CREATE TABLE `champion`
(
    `id`            INT(11)         NOT NULL,
    `name`          VARCHAR(100)    NULL,
    `title`         VARCHAR(100)    NULL,
    `lore`          VARCHAR(1000)   NULL,
    `fullImg`       VARCHAR(100)    NULL,
    `spriteImg`     VARCHAR(100)    NULL,
    `imageGrp`      VARCHAR(100)    NULL,
    PRIMARY KEY (`id`)
);

/* item table */
CREATE TABLE `item`
(
    `id`            INT(11)         NOT NULL,
    `sanitizedDesc` VARCHAR(1000)   NULL,
    `plainText`     VARCHAR(100)    NULL,
    `name`          VARCHAR(100)    NULL,
    `fullImg`       VARCHAR(100)    NULL,
    `spriteImg`     VARCHAR(100)    NULL,
    `group`         VARCHAR(100)    NULL,
    `gold`          INT(11)         NULL,
    PRIMARY KEY (`id`)
);

/* match table */
CREATE TABLE `match`
(
    `id`            BIGINT(20)      NOT NULL,
    `mapID`         BIGINT(20)      NOT NULL,
    `matchCreation` BIGINT(20)      NOT NULL,
    `matchDuration` BIGINT(20)      NOT NULL,
    `matchMode`     VARCHAR(100)    NOT NULL,
    `matchType`     VARCHAR(100)    NOT NULL,
    `matchVersion`  VARCHAR(100)    DEFAULT NULL,
    `queueType`     VARCHAR(100)    NOT NULL,
    `region`        VARCHAR(10)     DEFAULT NULL,
    `season`        VARCHAR(100)    NOT NULL,
    PRIMARY KEY (`id`)
);

/* team table */
CREATE TABLE `team`
(
    `id`            BIGINT(20)      NOT NULL AUTO_INCREMENT,
    `teamID`        INT(11)         NOT NULL,
    `matchID`       BIGINT(20)      NOT NULL,
    `baronKills`    INT(11)         NOT NULL,
    `dragonKills`   INT(11)         NOT NULL,
    `firstBaron`    BOOLEAN         NOT NULL,
    `firstBlood`    BOOLEAN         NOT NULL,
    `firstDragon`   BOOLEAN         NOT NULL,
    `firstInhibitor` BOOLEAN        NOT NULL,
    `firstTower`    BOOLEAN         NOT NULL,
    `towerKills`    INT(11)         NOT NULL,
    `inhibitorKills` INT(11)        NOT NULL,
    `vilemawKills`  INT(11)         NOT NULL,
    `winner`        BOOLEAN         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_team_match_id` (`matchID`),
    CONSTRAINT `fk_team_match` FOREIGN KEY (`matchID`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

/* participant table */
CREATE TABLE `participant`
(
    `id`            INT(11)         NOT NULL,
    `matchID`       BIGINT(20)      NOT NULL,
    `championID`    INT(11)         NOT NULL,
    `spell1ID`      INT(11)         NOT NULL,
    `spell2ID`      INT(11)         NOT NULL,
    `teamID`        INT(11)         NOT NULL,
    PRIMARY KEY (`id`, `matchID`),
    KEY `fk_participant_match_id` (`matchID`),
    CONSTRAINT `fk_participant_match` FOREIGN KEY (`matchID`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION    
);

/* stats table */
CREATE TABLE `stats`
(
    `id`            BIGINT(20)      NOT NULL AUTO_INCREMENT,
    `participantID` INT(11)         NOT NULL,
    `matchID`       BIGINT(20)      NOT NULL,
    `champLevel`    INT(11)         NOT NULL,
    `item0`         INT(11)         NOT NULL,
    `item1`         INT(11)         NOT NULL,
    `item2`         INT(11)         NOT NULL,
    `item3`         INT(11)         NOT NULL,
    `item4`         INT(11)         NOT NULL,
    `item5`         INT(11)         NOT NULL,
    `item6`         INT(11)         NOT NULL,
    `kills`         INT(11)         NOT NULL,
    `doubleKills`   INT(11)         NOT NULL,
    `tripleKills`   INT(11)         NOT NULL,
    `quadraKills`   INT(11)         NOT NULL,
    `pentaKills`    INT(11)         NOT NULL,
    `deaths`        INT(11)         NOT NULL,
    `assists`       INT(11)         NOT NULL,
    `wardsPlaced`   INT(11)         NOT NULL,
    `wardsKilled`   INT(11)         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_stats_match_id` (`matchID`),
    KEY `fk_stats_participant_id` (`participantID`,`matchID`),
    CONSTRAINT `fk_stats_match` FOREIGN KEY (`matchID`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

/* event table */
CREATE TABLE `event` 
(
    `id`              BIGINT(20)      NOT NULL AUTO_INCREMENT,
    `eventType`       VARCHAR(100)    NOT NULL,
    `itemID`          INT(11)         DEFAULT NULL,
    `participantID`   INT(11)         DEFAULT NULL,
    `timestamp`       BIGINT(20)      NOT NULL,
    `matchID`         BIGINT(20)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_event_match_id` (`matchID`),
    KEY `fk_event_participant_id` (`participantID`,`matchID`),
    CONSTRAINT `fk_event_match` FOREIGN KEY (`matchID`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

/* banned_champion table */
CREATE TABLE `banned_champion`
(
    `id`            BIGINT(20)      NOT NULL AUTO_INCREMENT,
    `matchID`       BIGINT(20)      NOT NULL,
    `teamID`        INT(11)         NOT NULL,
    `championID`    INT(11)         NOT NULL,
    `pickTurn`      INT(11)         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_banned_champîon_match_id` (`matchID`),
    CONSTRAINT `fk_banned_champion_match` FOREIGN KEY (`matchID`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);