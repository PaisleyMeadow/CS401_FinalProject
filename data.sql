CREATE TABLE users (	
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL UNIQUE,
	username VARCHAR(64) NOT NULL UNIQUE, 
	password VARCHAR(64) NOT NULL,
	fname VARCHAR(32) NOT NULL,
	lname VARCHAR(32) NOT NULL,
	color_scheme VARCHAR(32) DEFAULT "default"
);

CREATE TABLE workspaces (	
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(32) NOT NULL,
	color VARCHAR(6) DEFAULT "fdf0d5",
	user_id INT,
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE images (	
	id INT AUTO_INCREMENT PRIMARY KEY,
	location VARCHAR(2048) NOT NULL, 
	url BOOLEAN NOT NULL,
	/* boolean is if its a url (1/true) or file location (0/false)*/
	workspace_id INT,
	FOREIGN KEY (workspace_id) REFERENCES workspaces(id)
);

CREATE TABLE notes (	
	id INT AUTO_INCREMENT PRIMARY KEY,
	content VARCHAR(2048), 
	color VARCHAR(6) DEFAULT "fdf0d5",
	workspace_id INT,
	FOREIGN KEY (workspace_id) REFERENCES workspaces(id)
);

CREATE TABLE videos (	
	id INT AUTO_INCREMENT PRIMARY KEY,
	url VARCHAR(2048) NOT NULL, 
	workspace_id INT,
	FOREIGN KEY (workspace_id) REFERENCES workspaces(id)
);