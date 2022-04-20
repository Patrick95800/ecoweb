/* Create table user*/
CREATE TABLE user (
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    firstname VARCHAR (255),
    lastname  VARCHAR (255),
	username  VARCHAR (255),
    email     VARCHAR (255) UNIQUE,
    password  VARCHAR (255),
    photo     INTEGER UNIQUE,
	roles     TEXT
);

/* Create table teacher_request*/
CREATE TABLE teacher_request (
    id        	 INTEGER PRIMARY KEY AUTOINCREMENT,
    firstname 	 VARCHAR (255),
    lastname  	 VARCHAR (255),
    email     	 VARCHAR (255) UNIQUE,
    password  	 VARCHAR (255),
    photo_id     INTEGER UNIQUE,
	description     TEXT
);

/* Create table file*/
CREATE TABLE file (
    id        	 	INTEGER PRIMARY KEY AUTOINCREMENT,
    name 	 		VARCHAR (255),
    extension   	VARCHAR (255),
    training_lesson	INTEGER UNIQUE REFERENCES training_lesson (id)
);

/* Create table training */
CREATE TABLE training (
    id        	INTEGER PRIMARY KEY AUTOINCREMENT,
    title 	 	VARCHAR (255),
	description TEXT,
    slug	  	VARCHAR (255),
    created_at  VARCHAR (255),
    updated_at  VARCHAR (255),
    image_id    INTEGER REFERENCES file (id) 
	
);

/* Create table training_section */
CREATE TABLE training_section (
	id        	INTEGER  PRIMARY KEY AUTOINCREMENT,
    title 	 	VARCHAR (255),
    slug	  	VARCHAR (255),
    quizz_id    INTEGER UNIQUE REFERENCES quizz (id),
	training_id	INTEGER REFERENCES training (id)
);

/* Create table training_lesson */
CREATE TABLE training_lesson (
    id        	INTEGER PRIMARY KEY AUTOINCREMENT,
    title 	 	VARCHAR (255),
	explanation	TEXT,
    video	  	TEXT,
	training_section_id	INTEGER REFERENCES training_section (id)
);

/* Create table quizz */
CREATE TABLE quizz (
    id        			INTEGER PRIMARY KEY AUTOINCREMENT,
	question_id			INTEGER REFERENCES question (id),
	training_section_id	INTEGER REFERENCES training_section (id)
);

/* Create table question */
CREATE TABLE question (
    id        	INTEGER PRIMARY KEY AUTOINCREMENT,
    title 	 	VARCHAR (255),
	explanation	TEXT,
	quizz_id	INTEGER REFERENCES quizz (id)
);

/* Create table answer */
CREATE TABLE answer (
    id        	INTEGER PRIMARY KEY AUTOINCREMENT,
    text 	 	VARCHAR (255),
	is_answer   BOOL,
	question_id	INTEGER REFERENCES question (id)
);