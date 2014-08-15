1- register
2- administer attendance, import from tryggivann.no
3- present on web

groups:

CREATE TABLE groups (
  id int(5) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255),
  description varchar(255),
  PRIMARY KEY(id),
  UNIQUE KEY(name)
)ENGINE=INNODB CHARACTER SET UTF8;

users:

CREATE TABLE users (
  id int(5) unsigned NOT NULL AUTO_INCREMENT,
  group_id int(5) unsigned NOT NULL,
  name text,
  year int(4),
  sex varchar(1) NOT NULL,
  image_path varchar(256),
  PRIMARY KEY(id),
  FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET UTF8;

attendance: 
CREATE TABLE attendance (
  user_id  int(5) unsigned NOT NULL,
  date date NOT NULL,
  comment text,
  attended int(1) DEFAULT 0,
  PRIMARY KEY CLUSTERED (user_id, date),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET UTF8;


