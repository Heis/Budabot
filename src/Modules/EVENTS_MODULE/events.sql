CREATE TABLE IF NOT EXISTS `events` (
	`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
	`time_submitted` INT NOT NULL,
	`submitter_name` VARCHAR(25) NOT NULL,
	`event_name` VARCHAR(255) NOT NULL,
	`event_date` INT,
	`event_desc` TEXT,
	`event_attendees` TEXT
);