/* PROJET 4 : BASE DE DONNÉÉE POUR SITE DE COMMANDE DE PLAT EN LIGNE--------------
----------------------------------------------------------------------------------
PARCOURS DE FORMATION DEVELOPPER D'APPLICATION PHP SYMFONY OPENCLASSROOMS --------
----------------------------------------------------------------------------------
------------------------------------------------------DATE : 03/12/219------------*/





/* CREATION DE LA STRUCTURE DE LA BASE DE DONNÉE ---------------------------------
----------------------------------------------------------------------------------*/

CREATE DATABASE IF NOT EXISTS blog CHARACTER SET `utf8`;

USE blog;

CREATE TABLE IF NOT EXISTS role (
                                  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                  name VARCHAR(45) NOT NULL,

                                  PRIMARY KEY (id)
)
  ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS user (
                                   id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                   role_id INT UNSIGNED NOT NULL ,
                                   surname VARCHAR(45) NOT NULL,
                                   first_name VARCHAR(45) NOT NULL,
                                   email VARCHAR(45) NOT NULL,
                                   login_name VARCHAR(45) NOT NULL,
                                   password VARCHAR(45) NOT NULL,

                                   PRIMARY KEY (id),

                                   CONSTRAINT fk_role_id
                                     FOREIGN KEY (role_id)
                                       REFERENCES role(id)

)
  ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS category (
                                      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                      category_name VARCHAR(45) NOT NULL,

                                      PRIMARY KEY (id)

)
  ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS post (
                                  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                  category_id INT UNSIGNED NOT NULL,
                                  user_id INT UNSIGNED NOT NULL,
                                  title VARCHAR(100) NOT NULL,
                                  content LONGTEXT NOT NULL,
                                  update_date DATETIME NOT NULL,
                                  preview_text VARCHAR(300) NOT NULL,

                                  PRIMARY KEY (id),

                                  CONSTRAINT fk_category_id
                                    FOREIGN KEY (category_id)
                                      REFERENCES category(id),

                                  CONSTRAINT fk_user_id
                                      FOREIGN KEY (user_id)
                                      REFERENCES user(id)

)
  ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS comment (
                                     id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                     post_id INT UNSIGNED NOT NULL ,
                                     comment_text VARCHAR(255) NOT NULL,
                                     update_date DATETIME null,
	                                 author VARCHAR(255) null,
                                     validation TINYINT(1) null,

                                     PRIMARY KEY (id),

                                     CONSTRAINT fk_post_id
                                       FOREIGN KEY (post_id)
                                         REFERENCES post(id)

)
  ENGINE = INNODB;

INSERT INTO blog.role (id, name) VALUES (1, 'Administrateur');
INSERT INTO blog.role (id, name) VALUES (2, 'Redacteur');
INSERT INTO blog.role (id, name) VALUES (3, 'Utilisateur');




