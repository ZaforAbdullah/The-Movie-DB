use moviedb;

DROP TABLE IF EXISTS `Movie`;

CREATE TABLE IF NOT EXISTS `Movie` (
  `id` int(30) PRIMARY KEY,
  `title` varchar(300) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `url` varchar(350),
  `location` varchar(350)
);