# kringloop

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `artikel` (
`id` int NOT NULL,
`categorie_id` int NOT NULL,
`naam` varchar(255) NOT NULL,
`prijs_ex_btw` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categorie` (
`id` int NOT NULL,
`categorie` varchar(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `gebruiker` (
`id` int NOT NULL,
`gebruikersnaam` varchar(255) NOT NULL,
`wachtwoord` varchar(255) NOT NULL,
`rollen` text NOT NULL,
`is_geverifieerd` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `klant` (
`id` int NOT NULL,
`naam` varchar(255) NOT NULL,
`adres` varchar(255) NOT NULL,
`plaats` varchar(255) NOT NULL,
`telefoon` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `planning` (
`id` int NOT NULL,
`artikel_id` int NOT NULL,
`klant_id` int NOT NULL,
`kenteken` varchar(255) NOT NULL,
`ophalen_of_bezorgen` enum('ophalen','bezorgen') NOT NULL,
`afspraak_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `status` (
`id` int NOT NULL,
`status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `verkopen` (
`id` int NOT NULL,
`klant_id` int NOT NULL,
`artikel_id` varchar(255) NOT NULL,
`verkocht_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `voorraad` (
`id` int NOT NULL,
`artikel_id` int NOT NULL,
`locatie` varchar(255) NOT NULL,
`aantal` int NOT NULL,
`status_id` int NOT NULL,
`ingeboekt_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

//INDEXEN BESTAANDE

ALTER TABLE `artikel`
	ADD PRIMARY KEY (`id`),
    ADD KEY `categorie_id` (`categorie_id`);

ALTER TABLE `categorie`
	ADD PRIMARY KEY (`id`);

ALTER TABLE `gebruiker`
	ADD PRIMARY KEY (`id`);

ALTER TABLE `klant`
	ADD PRIMARY KEY (`id`);

 ALTER TABLE `planning`
	ADD PRIMARY KEY (`id`),
    ADD KEY `artikel_id`(`artikel_id`,`klant_id`),
    ADD KEY `klant_id`(`klant_id`);

ALTER TABLE `status`
	ADD PRIMARY KEY (`id`);

 ALTER TABLE `verkopen`
	ADD PRIMARY KEY (`id`),
    ADD KEY `klant_id`(`klant_id`,`artikel_id`),
    ADD KEY `artikel_id`(`artikel_id`);

 ALTER TABLE `voorraad`
	ADD PRIMARY KEY (`id`),
    ADD KEY `artikel_id`(`artikel_id`,`status_id`),
    ADD KEY `status_id`(`status_id`);

//AUTO INCREMENTS

ALTER TABLE `artikel`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `categorie`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;
    
ALTER TABLE `klant`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;
    
ALTER TABLE `planning`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `status`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;
    
ALTER TABLE `verkopen`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;
    
ALTER TABLE `voorraad`
	MODIFY `id` int NOT NULL AUTO_INCREMENT;

 //BEPERKINGEN

 ALTER TABLE `artikel`
ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

 ALTER TABLE `planning`
ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`),
ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`);


 ALTER TABLE `verkopen`
ADD CONSTRAINT `verkopen_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`),
ADD CONSTRAINT `verkopen_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`);


 ALTER TABLE `voorraad`
ADD CONSTRAINT `voorraad_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
ADD CONSTRAINT `voorraad_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
