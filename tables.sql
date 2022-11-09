users	CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8	

stories	CREATE TABLE `stories` (
  `story_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `link` text DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `story_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8	

comments	CREATE TABLE `comments` (
  `comment_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `comment_body` text NOT NULL,
  `story_id` mediumint(8) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`),
  KEY `story_id` (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`story_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8	
