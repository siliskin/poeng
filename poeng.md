1- register
2- administer attendance, import from tryggivann.no
3- present on web

groups:

CREATE TABLE groups (
  id int(5) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255),
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

activities:

CREATE TABLE activities (
  id int(5) unsigned NOT NULL AUTO_INCREMENT,
  name text,
  points smallint(2),
  PRIMARY KEY(id)
)ENGINE=INNODB CHARACTER SET UTF8;

points:

CREATE TABLE points (  
  user_id int(5) unsigned NOT NULL,
  group_id int(5) unsigned NOT NULL,
  points int,
  rank int(3),
  PRIMARY KEY(user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET UTF8;

CREATE TABLE schedule (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  activity_id  int(5) unsigned NOT NULL,
  name  varchar(256),
  start_date datetime DEFAULT NULL,
  days int(5),
  target_groups varchar(256),
  PRIMARY KEY(id),
  FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET UTF8;

attendance: 
CREATE TABLE attendance (
  user_id  int(5) unsigned NOT NULL,
  schedule_id  int(11) unsigned NOT NULL,
  date datetime DEFAULT NULL,
  PRIMARY KEY CLUSTERED (user_id, date),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (schedule_id) REFERENCES schedule(id) ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET UTF8;


