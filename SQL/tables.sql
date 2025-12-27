CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(250) NOT NULL,
    role ENUM('ADMIN','FORMATEUR','ETUDIANT')
)ENGINE=INNODB; 

CREATE TABLE departments(
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)ENGINE=INNODB; 

CREATE TABLE etudiants(
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
	matricule VARCHAR(100) NOT NULL ,
    departement_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)ENGINE=INNODB; 

CREATE TABLE formateurs(
	id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    specialite VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)ENGINE=INNODB; 

CREATE TABLE courses(
	id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(id)
)ENGINE=INNODB;

CREATE TABLE etudiant_course (
    etudiant_id INT,
    course_id INT,
    PRIMARY KEY (etudiant_id, course_id),
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
)ENGINE=INNODB; 
CREATE TABLE formateur_course (
    formateur_id INT,
    course_id INT,
    PRIMARY KEY (formateur_id, course_id),
    FOREIGN KEY (formateur_id) REFERENCES formateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
)ENGINE=INNODB; 

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department_id INT NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id)
    formateur_id INT NOT NULL,
    FOREIGN KEY (formateur_id) REFERENCES formateur(id)
)ENGINE=INNODB;

CREATE TABLE deparetement (
    id int primary KEY AUTO_INCRIMENT,
    firstname VARCHAR(200),
    lastname VARCHAR(200)

)ENGINE=INNODB;