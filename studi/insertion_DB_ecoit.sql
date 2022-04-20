/* Insert values into table user */
INSERT INTO user (firstname, lastname, username, email, password, photo, roles)
VALUES
 ('Patrick', 'Barros', 'patou', 'patrick.barros@ecoweb.com', 'patpat', 1, 'ROLE_ADMIN'),
 ('Jonathan', 'Pierrot', 'jonap', 'jonathan.pierrot@ecoweb.com', 2, 'C:\joe.png', 'ROLE_FORMATEUR');

/* Insert values into table teacher_request */ 
INSERT INTO teacher_request (firstname, lastname, email, password, photo_id, description)
   VALUES
 ('Thomas', 'Carpentier',  'thomas.carpentier@prof.com', 'tomtom', 3, "je veux être prof"),
 ('Elodie', 'Granger', 'elodie.granger@nature.com', 'eloelo', 4, "j\'aime la nature");

/* Insert values into table file */
INSERT INTO file (name, extension)
   VALUES
  ('pat.png', 'png'),
  ('joe.png', 'png'),
  ('tom.png', 'png'),
  ('elo.png', 'png'),
  ('training1.jpg', 'jpg'),
  ('video.mp4', 'mp4');
  
/* Insert values into table training */
INSERT INTO training (title, description, slug, created_at, updated_at , image_id)
   VALUES
 ("L\'obsolescence programmée",
  "L\'obsolescence programmée est, aux termes de la loi française",
  'obsolescence-programmee',
  '2022-04-01',
  '2022-04-15',
  5);


/* Insertion table training_section */             
INSERT INTO training_section (title, slug, training_id)
   VALUES					 
 ('Definition générale',
  'definition-generale',
  1); 	

/* Insertion table training_lesson */             
INSERT INTO training_lesson (title, explanation, video, training_section_id)
   VALUES					 
 ("Quel est le but de l\'obsolescence programmée ?",
  "C\'est la mise sur le marché d\'un produit dont on determine délibérément la durée de vie",
  6,
  1); 

/* Insertion table quizz */             
INSERT INTO quizz (training_section_id)
   VALUES					 
 (1);

/* Insertion table question */             
INSERT INTO question (title, explanation, quizz_id)
   VALUES					 
 ("Quand est apparu l\'obsolescence programmée ?",
  "En 1932, l\'américain Bernard London propose l\'idée de relancer l\'économie...",
  1);
  
  
 /* Insertion table answer */             
INSERT INTO answer (text, is_answer, question_id)
   VALUES					 
 ('En 1932',
  true,
  1),
  
 ('En 1942',
  false,
  1),
  
 ('En 1952',
  false,
  1);