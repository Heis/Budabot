CREATE TABLE IF NOT EXISTS notes (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	owner VARCHAR(25) NOT NULL,
	added_by VARCHAR(25) NOT NULL,
	note TEXT NOT NULL,
	dt INTEGER NOT NULL
);
