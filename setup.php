<?php 

include "config.php";

$setup_code = <<<MYSQL

CREATE TABLE IF NOT EXISTS `labels` (
  `subject` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(127) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `labels` (`subject`, `text`) VALUES
('labels', 'Labels'),
('TournamentMode', 'Tournament Modes'),
('TournamentRankings.MemberID', 'Member');

CREATE TABLE IF NOT EXISTS `Member` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Birth` date DEFAULT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `Member` (`MemberID`, `Name`, `Birth`) VALUES
(1, 'John Doe', '1985-10-14'),
(2, 'Jane Doe', '1995-10-27'),
(3, 'John Smith', '1984-05-21');

CREATE TABLE IF NOT EXISTS `Tournament` (
  `TournamentID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Place` varchar(127) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Day` date NOT NULL,
  `ModeID` int(11) DEFAULT NULL,
  `Announcement` int(11) DEFAULT NULL,
  PRIMARY KEY (`TournamentID`),
  KEY `Mode` (`ModeID`),
  KEY `Tournament_ibfk_2` (`Announcement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `Tournament` (`TournamentID`, `Name`, `Place`, `Day`, `ModeID`, `Announcement`) VALUES
(1, 'Yearly Summer Tournament', NULL, '2020-06-26', 2, NULL),
(2, 'Yearly Summer Tournament', NULL, '2019-06-21', 2, NULL),
(3, 'Yearly Summer Tournament', NULL, '2018-06-22', 3, NULL);

CREATE TABLE IF NOT EXISTS `TournamentMode` (
  `ModeID` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ModeID`),
  UNIQUE KEY `Description` (`Description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `TournamentMode` (`ModeID`, `Description`) VALUES
(3, 'Elimination'),
(1, 'Pools'),
(2, 'Pools+Elimination');

CREATE TABLE IF NOT EXISTS `TournamentRankings` (
  `TournamentID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `rank` tinyint(4) NOT NULL,
  PRIMARY KEY (`TournamentID`,`MemberID`),
  KEY `MemberID` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `TournamentRankings` (`TournamentID`, `MemberID`, `rank`) VALUES
(1, 3, 1),
(1, 1, 2),
(1, 2, 3);

CREATE TABLE IF NOT EXISTS `Uploads` (
  `Uploads_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Size` int(11) NOT NULL,
  `Content` longblob NOT NULL,
  PRIMARY KEY (`Uploads_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `Tournament`
  ADD CONSTRAINT `Tournament_ibfk_1` FOREIGN KEY (`ModeID`) REFERENCES `TournamentMode` (`ModeID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Tournament_ibfk_2` FOREIGN KEY (`Announcement`) REFERENCES `Uploads` (`Uploads_ID`) ON DELETE SET NULL;

ALTER TABLE `TournamentRankings`
  ADD CONSTRAINT `TournamentRankings_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TournamentRankings_ibfk_2` FOREIGN KEY (`TournamentID`) REFERENCES `Tournament` (`TournamentID`) ON DELETE CASCADE ON UPDATE CASCADE;

MYSQL;

header('Content-type: text/plain');

$pdo = new PDO(sprintf('mysql:dbname=%s;host=%s;charset=utf8', $DB_CONNECTION['db'], $DB_CONNECTION['server']), $DB_CONNECTION['user'], $DB_CONNECTION['pw'] );
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try
{ 
   $pdo->beginTransaction();
   foreach( preg_split("/\n\n+/", $setup_code) as $stmt )
   {
      $pdo->exec($stmt);
   }
   $pdo->commit();
   print("setup done!");
}
catch( \PDOException $e )
{
   $pdo->rollBack();
   print "error: " . $pdo->errorInfo()[2];
}


