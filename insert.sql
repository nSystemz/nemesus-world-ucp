-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Apr 2023 um 14:07
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `ucptest`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adminlogs`
--

CREATE TABLE `adminlogs` (
  `id` int(11) NOT NULL,
  `loglabel` varchar(35) NOT NULL,
  `text` varchar(256) NOT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `miscellaneous` int(11) DEFAULT 10,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adminlogsnames`
--

CREATE TABLE `adminlogsnames` (
  `id` int(11) NOT NULL,
  `loglabel` varchar(35) NOT NULL,
  `name` varchar(35) NOT NULL,
  `rang` int(2) NOT NULL DEFAULT 1,
  `checkip` int(1) NOT NULL DEFAULT 0,
  `miscellaneous` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adminsettings`
--

CREATE TABLE `adminsettings` (
  `id` int(11) NOT NULL,
  `adminpassword` varchar(255) NOT NULL,
  `server_created` int(11) NOT NULL DEFAULT 1609462861,
  `punishments` int(7) NOT NULL DEFAULT 0,
  `voicerp` int(1) NOT NULL DEFAULT 1,
  `govvalue` int(11) NOT NULL DEFAULT 0,
  `changelogcd` int(11) NOT NULL DEFAULT 1609462861,
  `towedcash` int(4) NOT NULL DEFAULT 250,
  `lsteuer` int(3) NOT NULL DEFAULT 7,
  `gsteuer` int(3) NOT NULL DEFAULT 5,
  `ksteuer` float NOT NULL DEFAULT 0.25,
  `groupsettings` varchar(150) NOT NULL DEFAULT '3750,1500,55000,65000,55000,45000,42500',
  `adcount` int(5) NOT NULL DEFAULT 0,
  `adprice` int(5) NOT NULL DEFAULT 1500,
  `admoney` int(11) NOT NULL DEFAULT 0,
  `dailyguesslimit` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animations`
--

CREATE TABLE `animations` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `animation` varchar(128) NOT NULL,
  `category` varchar(64) NOT NULL,
  `duration` int(5) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `banknumber` varchar(20) NOT NULL DEFAULT 'n/A',
  `bankvalue` int(11) NOT NULL DEFAULT 0,
  `pincode` varchar(4) NOT NULL DEFAULT '0000',
  `ownercharid` int(11) NOT NULL DEFAULT 0,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `banktype` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bankfile`
--

CREATE TABLE `bankfile` (
  `id` int(11) NOT NULL,
  `bankid` int(11) NOT NULL,
  `bankfrom` varchar(25) NOT NULL,
  `bankto` varchar(25) NOT NULL,
  `banktext` varchar(64) NOT NULL,
  `bankvalue` int(11) NOT NULL DEFAULT 0,
  `banktime` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `banksettings`
--

CREATE TABLE `banksettings` (
  `id` int(11) NOT NULL,
  `banknumber` varchar(13) NOT NULL DEFAULT 'n/A',
  `setting` varchar(25) NOT NULL DEFAULT 'n/A',
  `value` varchar(25) NOT NULL DEFAULT 'n/A',
  `name` varchar(35) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `banname` varchar(35) NOT NULL,
  `banfrom` varchar(35) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `text` varchar(35) NOT NULL,
  `identifier` varchar(128) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `business`
--

CREATE TABLE `business` (
  `id` int(11) NOT NULL,
  `posx` float NOT NULL,
  `posy` float NOT NULL,
  `posz` float NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `name` varchar(64) NOT NULL DEFAULT 'Business',
  `name2` varchar(64) NOT NULL DEFAULT 'Business',
  `owner` varchar(35) NOT NULL DEFAULT 'n/A',
  `funds` int(11) NOT NULL DEFAULT 0,
  `products` int(4) NOT NULL DEFAULT 2000,
  `multiplier` float NOT NULL DEFAULT 1,
  `cash` int(11) NOT NULL DEFAULT 0,
  `govcash` int(11) NOT NULL DEFAULT 0,
  `prodprice` int(4) NOT NULL DEFAULT 0,
  `blipid` int(4) NOT NULL DEFAULT 1,
  `buyproducts` int(1) NOT NULL DEFAULT 0,
  `selled` int(2) NOT NULL DEFAULT 0,
  `getmoney` int(11) NOT NULL DEFAULT 25000,
  `elec` int(3) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `busroutes`
--

CREATE TABLE `busroutes` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `routes` longtext NOT NULL,
  `advert` longtext NOT NULL,
  `skill` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cctvs`
--

CREATE TABLE `cctvs` (
  `id` int(11) NOT NULL,
  `who` varchar(35) NOT NULL,
  `from` varchar(35) NOT NULL,
  `position` varchar(64) NOT NULL,
  `heading` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `json` longtext NOT NULL,
  `cash` int(11) NOT NULL DEFAULT 5000,
  `birth` varchar(10) NOT NULL DEFAULT '01.01.2000',
  `bank` int(11) NOT NULL DEFAULT 0,
  `size` varchar(10) NOT NULL DEFAULT 'n/A',
  `eyecolor` varchar(10) NOT NULL DEFAULT 'n/A',
  `job` int(2) NOT NULL DEFAULT 0,
  `minijob` int(2) NOT NULL DEFAULT 0,
  `lastonline` int(11) NOT NULL DEFAULT 1609462861,
  `licenses` varchar(125) NOT NULL DEFAULT '0|0|0|0|0|0|0',
  `education` varchar(64) NOT NULL DEFAULT 'n/A',
  `origin` varchar(64) NOT NULL DEFAULT 'n/A',
  `skills` varchar(64) NOT NULL DEFAULT 'n/A',
  `appearance` varchar(64) NOT NULL DEFAULT 'n/A',
  `gender` int(1) NOT NULL DEFAULT 1,
  `faction` int(2) NOT NULL DEFAULT 0,
  `rang` int(2) NOT NULL DEFAULT 0,
  `faction_dutytime` int(4) NOT NULL DEFAULT 0,
  `faction_since` int(11) NOT NULL DEFAULT 1609462861,
  `last_spawn` varchar(35) NOT NULL DEFAULT 'Los-Santos',
  `ucp_privat` int(1) NOT NULL DEFAULT 0,
  `ck` int(11) NOT NULL DEFAULT 0,
  `mygroup` int(11) NOT NULL DEFAULT -1,
  `closed` int(1) NOT NULL DEFAULT 0,
  `tutorialstep` int(1) NOT NULL DEFAULT 0,
  `health` int(3) NOT NULL DEFAULT 100,
  `armor` int(2) NOT NULL DEFAULT 4,
  `thirst` int(3) NOT NULL DEFAULT 100,
  `hunger` int(3) NOT NULL DEFAULT 100,
  `screen` varchar(128) NOT NULL DEFAULT 'https://i.imgur.com/JjpH0qO.jpg',
  `lastpos` varchar(64) NOT NULL DEFAULT '0|0|0|0|0',
  `items` longtext NOT NULL,
  `inhouse` int(11) NOT NULL DEFAULT -1,
  `defaultbank` varchar(20) NOT NULL DEFAULT 'n/A',
  `online` int(1) NOT NULL DEFAULT 0,
  `truckerskill` int(4) NOT NULL DEFAULT 45,
  `nextpayday` int(6) NOT NULL DEFAULT 0,
  `payday_points` int(2) NOT NULL DEFAULT 0,
  `sellprods` int(4) NOT NULL DEFAULT 0,
  `abusemoney` int(11) NOT NULL DEFAULT 0,
  `lastsmartphone` varchar(10) NOT NULL DEFAULT '',
  `thiefskill` int(4) NOT NULL DEFAULT 25,
  `fishingskill` int(4) NOT NULL DEFAULT 35,
  `busskill` int(4) NOT NULL DEFAULT 35,
  `farmingskill` int(4) NOT NULL DEFAULT 25,
  `animations` longtext NOT NULL DEFAULT '["n/A","n/A","n/A","n/A","n/A","n/A","n/A","n/A","n/A"]',
  `walkingstyle` varchar(35) NOT NULL DEFAULT '',
  `clothing` varchar(20) NOT NULL DEFAULT '1,1,1,1,1,1,1,1',
  `factionduty` tinyint(1) NOT NULL,
  `sapoints` int(2) NOT NULL DEFAULT 0,
  `swat` int(1) NOT NULL DEFAULT 0,
  `arrested` int(4) NOT NULL DEFAULT 0,
  `cell` int(1) NOT NULL DEFAULT 0,
  `dutyjson` longtext NOT NULL DEFAULT '{"clothing":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],"clothingColor":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]}',
  `death` tinyint(1) NOT NULL DEFAULT 0,
  `disease` int(1) NOT NULL,
  `craftingskill` int(2) NOT NULL DEFAULT 25,
  `robcooldown` int(11) NOT NULL DEFAULT 0,
  `adcount` int(5) NOT NULL DEFAULT 0,
  `guessvalue` int(5) NOT NULL DEFAULT 0,
  `jobless` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `characters`
--

INSERT INTO `characters` (`id`, `userid`, `name`, `json`, `cash`, `birth`, `bank`, `size`, `eyecolor`, `job`, `minijob`, `lastonline`, `licenses`, `education`, `origin`, `skills`, `appearance`, `gender`, `faction`, `rang`, `faction_dutytime`, `faction_since`, `last_spawn`, `ucp_privat`, `ck`, `mygroup`, `closed`, `tutorialstep`, `health`, `armor`, `thirst`, `hunger`, `screen`, `lastpos`, `items`, `inhouse`, `defaultbank`, `online`, `truckerskill`, `nextpayday`, `payday_points`, `sellprods`, `abusemoney`, `lastsmartphone`, `thiefskill`, `fishingskill`, `busskill`, `farmingskill`, `animations`, `walkingstyle`, `clothing`, `factionduty`, `sapoints`, `swat`, `arrested`, `cell`, `dutyjson`, `death`, `disease`, `craftingskill`, `robcooldown`, `adcount`, `guessvalue`, `jobless`) VALUES
(1, 1, 'Test Char', '{\"birth\":\"22.10.1991\",\"origin\":\"Los Santos\",\"hair\":[1,16,0],\"beard\":[255,0],\"blendData\":[12,0,0,0,0,0],\"faceFeatures\":[0.9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],\"clothing\":[15,15,14,34,15,0,255,255,0,255,255,255,0,0,0],\"clothingColor\":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],\"headOverlays\":[23,14,255,-1,255,-1,-1,-1,255,-1,-1,-1],\"headOverlaysColors\":[0,0,0,0,0,0,0,0,0,0,0,0],\"eyeColor\":0,\"gender\":true}', 1104983, '12.12.1980', 0, '01m - 20cm', 'Grün', 1, 0, 1682445187, '0|0|1|0|0|0|0', 'Test', 'Los Santos', 'High School Abschluss', 'Test', 1, 0, 0, 0, 1682115269, 'Los-Santos', 1, 1634304377, 19, 0, 4, 85, 7, 0, 0, 'https://i.imgur.com/RdI0oWK.jpg', '-2016,0665|5484,229|-0,028296605|-57,690697|0', '[{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":29,\"hash\":\"974883178\",\"description\":\"Smartphone\",\"amount\":1,\"type\":4,\"weight\":115,\"props\":\"0189771044\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":30,\"hash\":\"n/A\",\"description\":\"n/A\",\"amount\":1,\"type\":0,\"weight\":0,\"props\":\"Ibuprofee-800mg\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":31,\"hash\":\"-1158162337\",\"description\":\"Gehstock\",\"amount\":2,\"type\":4,\"weight\":415,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":32,\"hash\":\"-1158162337\",\"description\":\"Lottoschein\",\"amount\":1,\"type\":4,\"weight\":50,\"props\":\"n/A26,23,4,38,46,39\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":33,\"hash\":\"-1282513796\",\"description\":\"EC-Karte\",\"amount\":1,\"type\":3,\"weight\":85,\"props\":\"SA3701-415423\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":34,\"hash\":\"-1158162337\",\"description\":\"Parkkralle\",\"amount\":0,\"type\":4,\"weight\":4500,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":35,\"hash\":\"-1158162337\",\"description\":\"Marihuanasamen\",\"amount\":4,\"type\":4,\"weight\":5,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":36,\"hash\":\"-1158162337\",\"description\":\"Materialien\",\"amount\":248,\"type\":4,\"weight\":10,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":37,\"hash\":\"-1282513796\",\"description\":\"EC-Karte\",\"amount\":1,\"type\":3,\"weight\":85,\"props\":\"SA3701-459250\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":38,\"hash\":\"494219267\",\"description\":\"Bizzschlüssel\",\"amount\":1,\"type\":3,\"weight\":55,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":39,\"hash\":\"-1282513796\",\"description\":\"EC-Karte\",\"amount\":1,\"type\":3,\"weight\":85,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":40,\"hash\":\"494219267\",\"description\":\"Bizzschlüssel\",\"amount\":1,\"type\":3,\"weight\":55,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":41,\"hash\":\"-1158162337\",\"description\":\"Drohne\",\"amount\":1,\"type\":4,\"weight\":2500,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":42,\"hash\":\"-1158162337\",\"description\":\"Kleines-Messer\",\"amount\":1,\"type\":4,\"weight\":250,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":43,\"hash\":\"-1158162337\",\"description\":\"7.62-Munition\",\"amount\":22,\"type\":6,\"weight\":5,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":44,\"hash\":\"-1910604593\",\"description\":\"Angel\",\"amount\":1,\"type\":4,\"weight\":500,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":45,\"hash\":\"-1158162337\",\"description\":\"Köder\",\"amount\":14,\"type\":1,\"weight\":25,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":46,\"hash\":\"494219267\",\"description\":\"Bizzschlüssel\",\"amount\":1,\"type\":3,\"weight\":55,\"props\":\"n/A0\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":47,\"hash\":\"-1158162337\",\"description\":\"5.56-Munition\",\"amount\":10,\"type\":6,\"weight\":4,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":48,\"hash\":\"-1158162337\",\"description\":\"Kleine-Schutzweste\",\"amount\":1,\"type\":5,\"weight\":1250,\"props\":\"25,0,10,876619137456,Administrativ|Phoenix Carter,0,|\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":49,\"hash\":\"-1158162337\",\"description\":\"Schaufel\",\"amount\":1,\"type\":4,\"weight\":650,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":50,\"hash\":\"-1158162337\",\"description\":\"Spitzhacke\",\"amount\":1,\"type\":4,\"weight\":650,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":51,\"hash\":\"-1158162337\",\"description\":\"Kleine-Schaufel\",\"amount\":1,\"type\":4,\"weight\":375,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":52,\"hash\":\"-1158162337\",\"description\":\"Mikrofon\",\"amount\":1,\"type\":4,\"weight\":500,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":53,\"hash\":\"-1158162337\",\"description\":\"Filmkamera\",\"amount\":1,\"type\":4,\"weight\":2350,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":54,\"hash\":\"-1158162337\",\"description\":\"Ghettoblaster\",\"amount\":1,\"type\":4,\"weight\":1500,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":55,\"hash\":\"494219267\",\"description\":\"Hausschlüssel\",\"amount\":1,\"type\":3,\"weight\":55,\"props\":\"n/A\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":56,\"hash\":\"-1158162337\",\"description\":\"Pistole\",\"amount\":1,\"type\":5,\"weight\":900,\"props\":\"0,0,0,556490198004,Administrativ|Phoenix Carter,0,|\",\"misc\":0},{\"ownerid\":1,\"owneridentifier\":\"Player\",\"itemid\":57,\"hash\":\"-1158162337\",\"description\":\"Funkgerät\",\"amount\":1,\"type\":4,\"weight\":200,\"props\":\"n/A\",\"misc\":0}]', -1, 'SA3701-459250', 0, 225, 0, 20, 144, 0, '0189771044', 32, 47, 36, 150, '[\"n/A\",\"n/A\",\"n/A\",\"dance\",\"n/A\",\"n/A\",\"n/A\",\"n/A\",\"n/A\"]', 'move_m@multiplayer', '1,1,1,1,1,1,1,1', 1, 2, 0, 0, 0, '{\"clothing\":[452,0,121,0,179,0,56,149,0,0,0,0,155,0,0,0],\"clothingColor\":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]}', 0, 2, 27, 1672071991, 0, 375, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cloths`
--

CREATE TABLE `cloths` (
  `id` int(11) NOT NULL,
  `component` int(4) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `drawable` int(4) NOT NULL,
  `color` int(4) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon` varchar(8) NOT NULL,
  `coupontext` varchar(35) NOT NULL,
  `usages` int(2) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(35) NOT NULL,
  `link` varchar(250) NOT NULL,
  `owner` varchar(35) NOT NULL,
  `creator` varchar(35) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `doors`
--

CREATE TABLE `doors` (
  `doorsid` int(11) NOT NULL,
  `id` int(11) NOT NULL DEFAULT 0,
  `hash` varchar(64) NOT NULL DEFAULT 'n/A',
  `posx` float NOT NULL DEFAULT 0,
  `posy` float NOT NULL DEFAULT 0,
  `posz` float NOT NULL DEFAULT 0,
  `dimension` int(11) NOT NULL DEFAULT 0,
  `toogle` tinyint(1) NOT NULL DEFAULT 0,
  `props` varchar(35) NOT NULL,
  `save` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `drugs`
--

CREATE TABLE `drugs` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `value` int(5) NOT NULL,
  `time` int(2) NOT NULL,
  `water` int(3) NOT NULL,
  `posx` varchar(25) NOT NULL,
  `posy` varchar(25) NOT NULL,
  `posz` varchar(25) NOT NULL,
  `posa` varchar(25) NOT NULL,
  `vw` int(6) NOT NULL,
  `drugname` varchar(35) NOT NULL DEFAULT 'Marihuana'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `factionbudgets`
--

CREATE TABLE `factionbudgets` (
  `id` int(11) NOT NULL,
  `faction` int(3) NOT NULL,
  `budget` int(7) NOT NULL DEFAULT 100000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `factions`
--

CREATE TABLE `factions` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `leader` int(11) NOT NULL DEFAULT -1,
  `created` int(11) NOT NULL DEFAULT 1609462861,
  `bankvalue` int(11) NOT NULL DEFAULT 0,
  `members` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `factionsalary`
--

CREATE TABLE `factionsalary` (
  `id` int(11) NOT NULL,
  `factionid` int(3) NOT NULL,
  `rang1` int(5) NOT NULL DEFAULT 0,
  `rang2` int(5) NOT NULL DEFAULT 0,
  `rang3` int(5) NOT NULL DEFAULT 0,
  `rang4` int(5) NOT NULL DEFAULT 0,
  `rang5` int(5) NOT NULL DEFAULT 0,
  `rang6` int(5) NOT NULL DEFAULT 0,
  `rang7` int(5) NOT NULL DEFAULT 0,
  `rang8` int(5) NOT NULL DEFAULT 0,
  `rang9` int(5) NOT NULL DEFAULT 0,
  `rang10` int(5) NOT NULL DEFAULT 0,
  `rang11` int(5) NOT NULL DEFAULT 0,
  `rang12` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `factionsrangs`
--

CREATE TABLE `factionsrangs` (
  `id` int(11) NOT NULL,
  `factionid` int(3) NOT NULL,
  `rang1` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang2` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang3` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang4` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang5` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang6` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang7` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang8` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang9` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang10` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang11` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang12` varchar(50) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fahndungen`
--

CREATE TABLE `fahndungen` (
  `id` int(11) NOT NULL,
  `text` varchar(575) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `creator` varchar(35) NOT NULL DEFAULT 'n/A',
  `editor` varchar(35) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fahndungskommentare`
--

CREATE TABLE `fahndungskommentare` (
  `id` int(11) NOT NULL,
  `fahndungsid` int(11) NOT NULL DEFAULT 0,
  `text` varchar(225) NOT NULL,
  `creator` varchar(35) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fire`
--

CREATE TABLE `fire` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `posx` float NOT NULL,
  `posy` float NOT NULL,
  `posz` float NOT NULL,
  `posa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `furniture`
--

CREATE TABLE `furniture` (
  `id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT 'n/A',
  `categorie` int(11) NOT NULL DEFAULT 0,
  `extra` int(2) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `furniturecategories`
--

CREATE TABLE `furniturecategories` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `furniturehouse`
--

CREATE TABLE `furniturehouse` (
  `id` int(11) NOT NULL,
  `house` int(11) NOT NULL DEFAULT 0,
  `extra` int(2) NOT NULL DEFAULT 0,
  `name` varchar(64) NOT NULL DEFAULT 'n/A',
  `hash` varchar(64) NOT NULL DEFAULT 'n/A',
  `position` varchar(128) NOT NULL DEFAULT '0.0|0.0|0.0|0.0|0.0|0.0|0',
  `props` longtext NOT NULL DEFAULT '[]',
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gangzones`
--

CREATE TABLE `gangzones` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `value` varchar(35) NOT NULL,
  `posx` varchar(10) NOT NULL,
  `posy` varchar(10) NOT NULL,
  `posz` varchar(10) NOT NULL,
  `heading` varchar(10) NOT NULL,
  `color` int(3) NOT NULL DEFAULT 39,
  `radius` int(3) NOT NULL DEFAULT 50,
  `percentages` longtext NOT NULL DEFAULT 'n/A',
  `things` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `garbageroutes`
--

CREATE TABLE `garbageroutes` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `routes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `globalitems`
--

CREATE TABLE `globalitems` (
  `id` int(11) NOT NULL DEFAULT 1,
  `json` longtext NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT 'n/A',
  `created` int(11) NOT NULL DEFAULT 1609462861,
  `banknumber` varchar(20) NOT NULL DEFAULT 'n/A',
  `leader` int(11) NOT NULL,
  `members` int(5) NOT NULL,
  `status` int(1) NOT NULL,
  `licenses` varchar(20) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0',
  `provision` int(3) NOT NULL DEFAULT 0,
  `maxplusvehicles` int(3) NOT NULL DEFAULT 0,
  `service` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groupsrangs`
--

CREATE TABLE `groupsrangs` (
  `id` int(11) NOT NULL,
  `groupsid` int(11) NOT NULL,
  `rang1` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang2` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang3` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang4` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang5` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang6` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang7` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang8` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang9` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang10` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang11` varchar(50) NOT NULL DEFAULT 'n/A',
  `rang12` varchar(50) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_members`
--

CREATE TABLE `groups_members` (
  `id` int(11) NOT NULL,
  `groupsid` int(11) NOT NULL,
  `charid` int(11) NOT NULL,
  `rang` int(2) NOT NULL DEFAULT 1,
  `duty_time` int(4) NOT NULL DEFAULT 0,
  `payday` int(7) NOT NULL DEFAULT 0,
  `payday_day` int(4) NOT NULL DEFAULT 0,
  `payday_since` int(4) NOT NULL DEFAULT 0,
  `since` int(11) NOT NULL DEFAULT 1634294819
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `houseinteriors`
--

CREATE TABLE `houseinteriors` (
  `id` int(11) NOT NULL,
  `ipl` varchar(128) NOT NULL DEFAULT 'n/A',
  `posx` float NOT NULL,
  `posy` float NOT NULL,
  `posz` float NOT NULL,
  `classify` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `posx` float NOT NULL,
  `posy` float NOT NULL,
  `posz` float NOT NULL,
  `dimension` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `interior` int(6) NOT NULL DEFAULT 0,
  `owner` varchar(35) NOT NULL DEFAULT 'n/A',
  `status` int(2) NOT NULL DEFAULT 0,
  `tenants` int(5) NOT NULL DEFAULT 0,
  `rental` int(11) NOT NULL DEFAULT 0,
  `locked` int(1) NOT NULL DEFAULT 0,
  `noshield` int(1) NOT NULL DEFAULT 0,
  `streetname` varchar(64) NOT NULL DEFAULT 'n/A',
  `blip` int(4) NOT NULL DEFAULT 40,
  `housegroup` int(6) NOT NULL DEFAULT -1,
  `stock` int(4) NOT NULL DEFAULT 3500,
  `stockprice` int(3) NOT NULL DEFAULT 30,
  `classify` int(2) NOT NULL DEFAULT 0,
  `elec` int(3) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inactiv`
--

CREATE TABLE `inactiv` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date1` int(11) NOT NULL,
  `date2` int(11) NOT NULL,
  `text` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `empfänger` varchar(64) NOT NULL DEFAULT 'n/A',
  `modus` varchar(35) NOT NULL DEFAULT 'Privatrechnung',
  `text` varchar(128) NOT NULL DEFAULT 'n/A',
  `banknumber` varchar(15) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itemmodels`
--

CREATE TABLE `itemmodels` (
  `id` int(11) NOT NULL,
  `hash` varchar(25) NOT NULL DEFAULT 'n/A',
  `description` varchar(64) NOT NULL DEFAULT 'n/A',
  `type` int(3) NOT NULL DEFAULT 0,
  `weight` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lifeinvaderads`
--

CREATE TABLE `lifeinvaderads` (
  `id` int(11) NOT NULL,
  `text` varchar(128) NOT NULL,
  `name` varchar(35) NOT NULL,
  `number` varchar(10) NOT NULL,
  `status` varchar(15) NOT NULL,
  `editor` varchar(35) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `loglabel` varchar(35) NOT NULL,
  `text` varchar(256) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `namechanges`
--

CREATE TABLE `namechanges` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `oldname` varchar(35) NOT NULL,
  `newname` varchar(35) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `outfits`
--

CREATE TABLE `outfits` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `owner` varchar(35) NOT NULL,
  `json1` longtext NOT NULL,
  `json2` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `paydays`
--

CREATE TABLE `paydays` (
  `id` int(11) NOT NULL,
  `characterid` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `timestamp` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `policefile`
--

CREATE TABLE `policefile` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL DEFAULT 'n/A',
  `police` varchar(35) NOT NULL DEFAULT 'n/A',
  `text` varchar(225) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861,
  `commentary` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `screenshots`
--

CREATE TABLE `screenshots` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `charid` int(11) NOT NULL,
  `screenshot` varchar(128) NOT NULL DEFAULT 'https://i.imgur.com/JjpH0qO.jpg',
  `screenname` varchar(128) NOT NULL DEFAULT 'n/A',
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `wartung` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shopitems`
--

CREATE TABLE `shopitems` (
  `id` int(11) NOT NULL,
  `shoplabel` varchar(64) NOT NULL DEFAULT '24/7',
  `itemname` varchar(64) NOT NULL DEFAULT 'n/A',
  `itemprice` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smartphonecalls`
--

CREATE TABLE `smartphonecalls` (
  `1` int(11) NOT NULL,
  `tonumber` varchar(15) NOT NULL,
  `fromnumber` varchar(15) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smartphonemessages`
--

CREATE TABLE `smartphonemessages` (
  `id` int(11) NOT NULL,
  `tomessage` varchar(15) NOT NULL,
  `frommessage` varchar(15) NOT NULL,
  `text` varchar(128) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smartphones`
--

CREATE TABLE `smartphones` (
  `id` int(11) NOT NULL,
  `phonenumber` varchar(10) NOT NULL DEFAULT 'n/A',
  `phoneprops` longtext NOT NULL,
  `contacts` longtext NOT NULL,
  `akku` int(2) NOT NULL DEFAULT 48,
  `prepaid` int(4) NOT NULL DEFAULT 55,
  `owner` varchar(35) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spedvehicles`
--

CREATE TABLE `spedvehicles` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT 'n/A',
  `capa` int(4) NOT NULL DEFAULT 0,
  `skill` int(1) NOT NULL DEFAULT 0,
  `skilltext` varchar(64) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `speedcameras`
--

CREATE TABLE `speedcameras` (
  `id` int(11) NOT NULL,
  `who` varchar(35) NOT NULL,
  `from` varchar(35) NOT NULL,
  `maxspeed` int(4) NOT NULL,
  `heading` float NOT NULL,
  `position` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `standingorder`
--

CREATE TABLE `standingorder` (
  `id` int(11) NOT NULL,
  `ownercharid` int(11) NOT NULL DEFAULT 0,
  `bankfrom` varchar(20) NOT NULL DEFAULT 'n/A',
  `bankto` varchar(20) NOT NULL DEFAULT 'n/A',
  `bankvalue` int(11) NOT NULL DEFAULT 0,
  `banktext` varchar(64) NOT NULL DEFAULT 'n/A',
  `days` int(3) NOT NULL DEFAULT 0,
  `daysrun` int(3) NOT NULL DEFAULT 0,
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tattoos`
--

CREATE TABLE `tattoos` (
  `id` int(11) NOT NULL,
  `characterid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `dlcname` varchar(64) NOT NULL,
  `zoneid` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `taxiroutes`
--

CREATE TABLE `taxiroutes` (
  `id` int(11) NOT NULL,
  `routes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `prio` varchar(10) NOT NULL,
  `text` varchar(3500) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT 1609462861,
  `admin` int(11) NOT NULL DEFAULT -1,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ticket_answers`
--

CREATE TABLE `ticket_answers` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ticket_user`
--

CREATE TABLE `ticket_user` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `timeline`
--

CREATE TABLE `timeline` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `charid` int(11) NOT NULL,
  `text` varchar(128) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transfer`
--

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `bankfrom` varchar(20) NOT NULL DEFAULT 'n/A',
  `bankto` varchar(20) NOT NULL DEFAULT 'n/A',
  `banktext` varchar(64) NOT NULL DEFAULT 'n/A',
  `bankvalue` int(11) NOT NULL DEFAULT 0,
  `bankname` varchar(35) NOT NULL DEFAULT 'n/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userfile`
--

CREATE TABLE `userfile` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `admin` varchar(35) NOT NULL,
  `text` varchar(60) NOT NULL,
  `penalty` varchar(35) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `action` varchar(128) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(35) NOT NULL,
  `adminlevel` int(2) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `admin_since` int(11) NOT NULL DEFAULT 1609462861,
  `selectedcharacter` int(3) NOT NULL DEFAULT -1,
  `selectedcharacterintern` int(11) NOT NULL DEFAULT -1,
  `last_login` int(11) NOT NULL DEFAULT 1609462861,
  `account_created` int(11) NOT NULL DEFAULT 1609462861,
  `last_save` int(11) NOT NULL DEFAULT 1609462861,
  `level` int(4) NOT NULL DEFAULT 1,
  `play_time` int(6) NOT NULL DEFAULT 0,
  `play_points` int(6) NOT NULL DEFAULT 0,
  `kills` int(6) NOT NULL DEFAULT 0,
  `deaths` int(6) NOT NULL DEFAULT 0,
  `crimes` int(6) NOT NULL DEFAULT 0,
  `premium` int(1) NOT NULL DEFAULT 0,
  `premium_time` int(11) NOT NULL DEFAULT 1609462861,
  `coins` int(6) NOT NULL DEFAULT 0,
  `warns` int(1) NOT NULL DEFAULT 0,
  `warns_text` varchar(175) NOT NULL DEFAULT 'n/A|n/A|n/A|n/A|n/A',
  `online` int(1) NOT NULL DEFAULT 0,
  `namechanges` int(3) NOT NULL DEFAULT 0,
  `geworben` varchar(35) NOT NULL DEFAULT 'Keiner',
  `theme` varchar(5) NOT NULL DEFAULT 'dark',
  `ban` int(11) NOT NULL DEFAULT 0,
  `bantext` varchar(35) NOT NULL DEFAULT 'n/A',
  `admin_rang` varchar(35) NOT NULL DEFAULT 'n/A',
  `prison` int(6) NOT NULL DEFAULT 0,
  `last_ip` varchar(64) NOT NULL DEFAULT 'n/A',
  `identifier` int(35) NOT NULL DEFAULT 10,
  `login_bonus` int(7) NOT NULL DEFAULT 0,
  `login_bonus_before` varchar(15) NOT NULL DEFAULT 'n/A',
  `google2fa_secret` text DEFAULT NULL,
  `dsgvo_closed` int(1) NOT NULL DEFAULT 0,
  `forumaccount` int(11) NOT NULL DEFAULT -1,
  `forumcode` int(4) NOT NULL DEFAULT 0,
  `forumupdate` int(11) NOT NULL DEFAULT 1609462861,
  `autologin` int(1) NOT NULL DEFAULT 0,
  `rpquizfinish` int(1) NOT NULL DEFAULT 0,
  `timestampchat` int(1) NOT NULL DEFAULT 1,
  `crosshair` int(3) NOT NULL DEFAULT 17,
  `shootingrange` int(4) NOT NULL DEFAULT 0,
  `faq` varchar(25) NOT NULL DEFAULT '1,0,0,0,0,0,0,0,0,0',
  `givepremium` int(1) NOT NULL DEFAULT 0,
  `houseslots` int(2) NOT NULL DEFAULT 0,
  `vehicleslots` int(2) NOT NULL DEFAULT 0,
  `epboost` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `adminlevel`, `password`, `remember_token`, `admin_since`, `selectedcharacter`, `selectedcharacterintern`, `last_login`, `account_created`, `last_save`, `level`, `play_time`, `play_points`, `kills`, `deaths`, `crimes`, `premium`, `premium_time`, `coins`, `warns`, `warns_text`, `online`, `namechanges`, `geworben`, `theme`, `ban`, `bantext`, `admin_rang`, `prison`, `last_ip`, `identifier`, `login_bonus`, `login_bonus_before`, `google2fa_secret`, `dsgvo_closed`, `forumaccount`, `forumcode`, `forumupdate`, `autologin`, `rpquizfinish`, `timestampchat`, `crosshair`, `shootingrange`, `faq`, `givepremium`, `houseslots`, `vehicleslots`, `epboost`) VALUES
(1, 'Testuser', 8, '$2y$10$6n4eP023KIEGINK1j6XE5Op3EDlh.t0BLMm4fXjEyh5CIbA6ra4t6', 'mpBECbLt2fRNcEiSMCVzNB1APnDOki1wdbulTsL6iikfzBxaLccd44IN8Kkg', 1633797716, 0, 1, 1633357259, 1633357259, 0, 1, 1, 8, 0, 0, 0, 1, 1633357259, 0, 1, 'test|testt|n/A|n/A|n/A', 0, 2, 'Keiner', 'dark', 0, 'testtt', 'Testrang', 0, 'n/A', 18021891, 1, '10-10-2022', NULL, 0, -1, 0, 1682087207, 0, 1, 1, 17, 0, '1,0,0,0,0,0,0,0,0,0', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `position` varchar(115) NOT NULL DEFAULT '0.0|0.0|0.0|0.0|0|0|0',
  `owner` varchar(35) DEFAULT NULL,
  `vehiclename` varchar(60) NOT NULL DEFAULT 'n/A',
  `ownname` varchar(60) NOT NULL DEFAULT 'n/A',
  `plate` varchar(10) NOT NULL DEFAULT 'n/A',
  `health` varchar(25) NOT NULL DEFAULT '1000.0|1000.0|1000.0',
  `battery` int(3) NOT NULL DEFAULT 100,
  `status` int(1) NOT NULL DEFAULT 1,
  `engine` int(1) NOT NULL DEFAULT 0,
  `kilometre` float NOT NULL DEFAULT 0,
  `tuev` int(11) NOT NULL DEFAULT 1633780009,
  `oel` int(3) NOT NULL DEFAULT 100,
  `fuel` float NOT NULL DEFAULT 0,
  `rang` int(2) NOT NULL DEFAULT 1,
  `tuning` longtext NOT NULL,
  `garage` varchar(25) NOT NULL DEFAULT 'n/A',
  `sync` varchar(35) NOT NULL DEFAULT '0,0,0,0,0,0,0',
  `color` varchar(25) NOT NULL DEFAULT '0,0,-1,-1',
  `products` int(4) NOT NULL DEFAULT 0,
  `vlock` int(1) NOT NULL DEFAULT 0,
  `doors` varchar(55) NOT NULL DEFAULT '[false,false,false,false,false]',
  `windows` varchar(55) NOT NULL DEFAULT '[false,false,false,false]',
  `towed` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vehicleshop`
--

CREATE TABLE `vehicleshop` (
  `id` int(11) NOT NULL,
  `bizzid` int(4) NOT NULL,
  `vehiclename` varchar(60) NOT NULL,
  `price` int(11) NOT NULL,
  `maxspeed` int(4) NOT NULL,
  `maxacceleration` float NOT NULL,
  `maxbraking` float NOT NULL,
  `maxhandling` float NOT NULL,
  `trunk` int(4) NOT NULL,
  `fuel` int(4) NOT NULL,
  `products` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `weapons`
--

CREATE TABLE `weapons` (
  `id` int(11) NOT NULL,
  `ident` varchar(12) NOT NULL,
  `name` varchar(35) NOT NULL,
  `shop` varchar(64) NOT NULL,
  `weaponname` varchar(64) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `whitelist`
--

CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `socialclubid` int(15) NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT 1609462861
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adminlogs`
--
ALTER TABLE `adminlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `adminlogsnames`
--
ALTER TABLE `adminlogsnames`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `adminsettings`
--
ALTER TABLE `adminsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `animations`
--
ALTER TABLE `animations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bankfile`
--
ALTER TABLE `bankfile`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `banksettings`
--
ALTER TABLE `banksettings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `busroutes`
--
ALTER TABLE `busroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cctvs`
--
ALTER TABLE `cctvs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cloths`
--
ALTER TABLE `cloths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon` (`coupon`);

--
-- Indizes für die Tabelle `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `doors`
--
ALTER TABLE `doors`
  ADD PRIMARY KEY (`doorsid`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `factionbudgets`
--
ALTER TABLE `factionbudgets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `factions`
--
ALTER TABLE `factions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `factionsalary`
--
ALTER TABLE `factionsalary`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `factionsrangs`
--
ALTER TABLE `factionsrangs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `fahndungen`
--
ALTER TABLE `fahndungen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `fahndungskommentare`
--
ALTER TABLE `fahndungskommentare`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indizes für die Tabelle `fire`
--
ALTER TABLE `fire`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `furniturecategories`
--
ALTER TABLE `furniturecategories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `furniturehouse`
--
ALTER TABLE `furniturehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gangzones`
--
ALTER TABLE `gangzones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `garbageroutes`
--
ALTER TABLE `garbageroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `globalitems`
--
ALTER TABLE `globalitems`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groupsrangs`
--
ALTER TABLE `groupsrangs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groups_members`
--
ALTER TABLE `groups_members`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `houseinteriors`
--
ALTER TABLE `houseinteriors`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `inactiv`
--
ALTER TABLE `inactiv`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `itemmodels`
--
ALTER TABLE `itemmodels`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `lifeinvaderads`
--
ALTER TABLE `lifeinvaderads`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `namechanges`
--
ALTER TABLE `namechanges`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `outfits`
--
ALTER TABLE `outfits`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indizes für die Tabelle `paydays`
--
ALTER TABLE `paydays`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indizes für die Tabelle `policefile`
--
ALTER TABLE `policefile`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `screenshots`
--
ALTER TABLE `screenshots`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shopitems`
--
ALTER TABLE `shopitems`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `smartphonecalls`
--
ALTER TABLE `smartphonecalls`
  ADD PRIMARY KEY (`1`);

--
-- Indizes für die Tabelle `smartphonemessages`
--
ALTER TABLE `smartphonemessages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `smartphones`
--
ALTER TABLE `smartphones`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `spedvehicles`
--
ALTER TABLE `spedvehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `speedcameras`
--
ALTER TABLE `speedcameras`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `standingorder`
--
ALTER TABLE `standingorder`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tattoos`
--
ALTER TABLE `tattoos`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `taxiroutes`
--
ALTER TABLE `taxiroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ticket_answers`
--
ALTER TABLE `ticket_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ticket_user`
--
ALTER TABLE `ticket_user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `userfile`
--
ALTER TABLE `userfile`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vehicleshop`
--
ALTER TABLE `vehicleshop`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adminlogs`
--
ALTER TABLE `adminlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `adminlogsnames`
--
ALTER TABLE `adminlogsnames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `adminsettings`
--
ALTER TABLE `adminsettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `animations`
--
ALTER TABLE `animations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bankfile`
--
ALTER TABLE `bankfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `banksettings`
--
ALTER TABLE `banksettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `business`
--
ALTER TABLE `business`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `busroutes`
--
ALTER TABLE `busroutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cctvs`
--
ALTER TABLE `cctvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `cloths`
--
ALTER TABLE `cloths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `doors`
--
ALTER TABLE `doors`
  MODIFY `doorsid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `drugs`
--
ALTER TABLE `drugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `factionbudgets`
--
ALTER TABLE `factionbudgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `factions`
--
ALTER TABLE `factions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `factionsalary`
--
ALTER TABLE `factionsalary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `factionsrangs`
--
ALTER TABLE `factionsrangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `fahndungen`
--
ALTER TABLE `fahndungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `fahndungskommentare`
--
ALTER TABLE `fahndungskommentare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `fire`
--
ALTER TABLE `fire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `furniturecategories`
--
ALTER TABLE `furniturecategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `furniturehouse`
--
ALTER TABLE `furniturehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `gangzones`
--
ALTER TABLE `gangzones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `garbageroutes`
--
ALTER TABLE `garbageroutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `groupsrangs`
--
ALTER TABLE `groupsrangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `groups_members`
--
ALTER TABLE `groups_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `houseinteriors`
--
ALTER TABLE `houseinteriors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `inactiv`
--
ALTER TABLE `inactiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `itemmodels`
--
ALTER TABLE `itemmodels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `lifeinvaderads`
--
ALTER TABLE `lifeinvaderads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `namechanges`
--
ALTER TABLE `namechanges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `outfits`
--
ALTER TABLE `outfits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `paydays`
--
ALTER TABLE `paydays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `policefile`
--
ALTER TABLE `policefile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `screenshots`
--
ALTER TABLE `screenshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `shopitems`
--
ALTER TABLE `shopitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `smartphonecalls`
--
ALTER TABLE `smartphonecalls`
  MODIFY `1` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `smartphonemessages`
--
ALTER TABLE `smartphonemessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `smartphones`
--
ALTER TABLE `smartphones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `spedvehicles`
--
ALTER TABLE `spedvehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `speedcameras`
--
ALTER TABLE `speedcameras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `standingorder`
--
ALTER TABLE `standingorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tattoos`
--
ALTER TABLE `tattoos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `taxiroutes`
--
ALTER TABLE `taxiroutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ticket_answers`
--
ALTER TABLE `ticket_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ticket_user`
--
ALTER TABLE `ticket_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `userfile`
--
ALTER TABLE `userfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vehicleshop`
--
ALTER TABLE `vehicleshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `weapons`
--
ALTER TABLE `weapons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
