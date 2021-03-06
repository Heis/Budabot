DROP TABLE IF EXISTS Cluster;
CREATE TABLE Cluster (
	ClusterID INT NOT NULL PRIMARY KEY,
	EffectTypeID INT NOT NULL,
	LongName VARCHAR(50) NOT NULL,
	NPReq INT NOT NULL,
	AltName VARCHAR(50) NOT NULL
);
INSERT INTO Cluster (ClusterID, EffectTypeID, LongName, NPReq, AltName) VALUES
(0,1,'',0,''),
(2,1,'1 Handed Blunt Weapons',720,'1h Blunt'),
(3,1,'1 Handed Edged Weapon',760,'1h Edged'),
(4,1,'2 Handed Blunt Weapons',720,'2h Blunt'),
(5,1,'2 Handed Edged Weapons',760,'2h Edged'),
(6,1,'Adventuring',600,''),
(7,2,'Agility',900,''),
(8,1,'Aimed Shot',840,''),
(9,1,'Assault Rifle',900,''),
(10,16,'Biological Metamorphosis',960,''),
(11,1,'Body Development',800,''),
(12,1,'Bow',800,''),
(13,1,'Bow Special Attack',800,''),
(14,1,'Brawling',660,'Brawl'),
(15,1,'Breaking and Entry',800,''),
(16,1,'Burst',840,''),
(17,3,'Chemical AC',800,''),
(18,1,'Chemistry',800,''),
(19,3,'Cold AC',800,''),
(20,1,'Computer Literacy',800,''),
(21,1,'Concealment',720,''),
(22,1,'Dimach',900,''),
(24,1,'Dodge Ranged Attacks',800,'Dodge Ranged'),
(25,1,'Duck Explosives',800,''),
(26,1,'Electrical Engineering',800,''),
(27,3,'Energy AC',900,''),
(28,1,'Evade Close Combat',800,'Evade Close'),
(29,1,'Fast Attack',760,''),
(30,3,'Fire AC',800,''),
(31,1,'First Aid',720,''),
(32,1,'Fling Shot',720,''),
(33,1,'Full Auto',900,''),
(34,1,'Grenade Throwing',760,'Grenade'),
(35,1,'Heavy Weapons',400,''),
(36,3,'Projectile AC',900,''),
(37,2,'Intelligence',900,''),
(38,1,'Map Navigation',500,''),
(39,1,'Martial Arts',1000,''),
(40,16,'Matter Creation',960,''),
(41,16,'Matter Metamorphosis',960,''),
(42,4,'Max Health',1000,''),
(43,4,'Max Nano',1000,''),
(44,1,'Mechanical Engineering',800,''),
(45,1,'Melee Energy Weapons',800,'Melee Energy'),
(46,1,'Melee Weapons Initiative',800,'Melee Init'),
(47,3,'Melee AC',900,''),
(48,1,'MG/SMG',800,'SMG'),
(49,1,'Multiple Melee Weapons',900,'Multi Melee'),
(50,1,'Multiple Ranged Weapons',800,'Multi Ranged'),
(51,1,'Nano Initiative',800,'Nano Init'),
(52,1,'Nano Pool',1200,''),
(53,1,'Nano Programming',800,''),
(54,1,'Nano Resistance',800,'Nano Resist'),
(55,1,'Parry',840,''),
(56,1,'Perception',800,''),
(57,1,'Pharmaceuticals',800,''),
(58,1,'Physical Initiative',800,'Physical Init'),
(59,1,'Piercing',640,''),
(60,1,'Pistol',800,''),
(61,2,'Psychic',900,''),
(62,16,'Psychological Modifications',960,''),
(63,1,'Psychology',800,''),
(64,1,'Quantum Physics',1000,''),
(65,3,'Radiation AC',800,''),
(66,1,'Ranged Energy',800,''),
(67,1,'Ranged Initiative',800,'Ranged Init'),
(68,1,'Rifle',900,''),
(69,1,'Riposte',1000,''),
(70,1,'Run Speed',1000,''),
(71,2,'Sense',900,''),
(72,16,'Sensory Improvement',880,''),
(73,1,'Sharp Objects',500,''),
(74,1,'Shotgun',680,''),
(75,1,'Sneak Attack',1000,''),
(76,2,'Stamina',900,''),
(77,2,'Strength',900,''),
(78,1,'Swimming',500,''),
(79,16,'Time and Space',960,''),
(80,1,'Trap Disarming',720,''),
(81,1,'Treatment',860,''),
(82,1,'Tutoring',520,''),
(83,1,'Vehicle Air',400,''),
(84,1,'Vehicle Ground',600,''),
(85,1,'Vehicle Water',480,''),
(86,1,'Weapon Smithing',800,''),
(87,15,'Nano Delta*',1,'Nano Delta'),
(88,15,'Heal Delta*',1,'Heal Delta'),
(89,8,'Add All Defense*',1,'Defense modifier'),
(90,9,'Add All Offense*',1,'Offense modifier'),
(91,10,'Add Max NCU*',1,'NCU Memory'),
(92,5,'Add XP (%)*',1,'Experience Modifier'),
(93,12,'Nano Interrupt (%)*',1,'Nano interrupt chance'),
(94,6,'Add Chemical Damage*',1,'Chemical damage modifier'),
(95,6,'Add Energy Damage*',1,'Energy damage modifier'),
(96,6,'Add Fire Damage*',1,'Fire damage modifier'),
(97,6,'Add Melee Damage*',1,'Melee damage modifier'),
(98,6,'Add Poison Damage*',1,'Poison damage modifier'),
(99,6,'Add Projectile Damage*',1,'Projectile damage modifier'),
(100,6,'Add Radiation Damage*',1,'Radiation damage modifier'),
(101,7,'Chemical Damage Shield*',1,'Shield Chemical Damage'),
(102,7,'Cold Damage Shield*',1,'Shield Cold Damage'),
(103,7,'Energy Damage Shield*',1,'Shield Energy Damage'),
(104,7,'Fire Damage Shield*',1,'Shield Fire Damage'),
(105,7,'Melee Damage Shield*',1,'Shield Melee Damage'),
(106,7,'Poison Damage Shield*',1,'Shield Poison Damage'),
(107,7,'Projectile Damage Shield*',1,'Shield Projectile Damage'),
(108,7,'Radiation Damage Shield*',1,'Shield Radiation Damage'),
(109,11,'Skill Lock (%)*',1,'Skill Lock Modifier'),
(110,13,'Nano Cost (%)*',1,'Nano cost modifier'),
(111,14,'Add Nano Range (%)*',1,'Nano Range'),
(112,3,'Poison AC',800,''),
(130,14,'Add Weapon Range (%)*',1,'');
