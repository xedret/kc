CREATE DATABASE IF NOT EXISTS `kc` DEFAULT CHARACTER SET latin1;

USE `kc`;

DROP TABLE IF EXISTS `api_users`;


CREATE TABLE `api_users` (
  `uid` varchar(36) NOT NULL,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `api_users` VALUES ('d8570a8ca9a3407abf3b6b6772f3d89c', 'robot', 'xedret@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1);


DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `sid` varchar(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `students` VALUES('ce45dad176e04007bfde9cacbd1b8ce0', 'Rene','Figaro','rene@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('c918a5b44e224bd99eecab6ee7e89824', 'Edgar','Figaro','edgar@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('e43ef81f8b5e4010aee9012e8fcb1aa6', 'Leo','Cristophe','leo@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('bc6e0133fdeb44dc8668d0f6bebd5eee', 'Relm','Arrowny','relm@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('a428d4cbda05428a94032cc9e721a0a2', 'Lock','Cole','locke@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('a3dbed10a41743a687584309c61ca896', 'Cyan','Garamonde','cyan@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('913a8f8eb0d74e86b5fcc579fdaa87f4', 'Siegfried','Sigurd','siegfried@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('fd62f20d4b254bc097b8f082c739ff6d', 'Tina','Brandford','tina@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('1a21c7b0efc54eaa9fd2611ddbcdffce', 'Kefka','Palazzo','kefka@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('6a1c3a74fae746859c78d2c6ecc3afaf', 'Celes','Chere','celes@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('8ed8ad54e5ee47a18367825bb9019a64', 'Vanille','Dia','vanille@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('36547ced902f476daba271dded0c3012', 'Kain','Highwind','kain@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('300b414e1f6d4b8e8ab40002c2ba5227', 'Aranea','Highwind','aranea@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('5adfc401c3bd4b9e99dd563b07fae539', 'Snow','Villiers','snow@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('a834fc6c50e143b685965d22e2d71722', 'Oerba','Yun','oerba@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('b87c0f5e5509429c8e55b460a94db5e2', 'Aerith','Gainsborough','aerith@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('ea46520af868485f85dfc6bbf3d99ff5', 'Cecil','Harvey','cecil@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('bfc8d04a5f3b40ca9f44dc6513ee09dd', 'Rosa Joanna','Farrel','rosa@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('ce228feef95846fdbdf6341e257b52c6', 'Bartz','Klauser','bartz@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);
INSERT INTO `students` VALUES('9b22fbb50280438a8fc047fb812f1bb9', 'Edward Chris','Von Muir','edward@randomdomain.com',"5f4dcc3b5aa765d61d8327deb882cf99",1);


DROP TABLE IF EXISTS `auth`;

CREATE TABLE `auth` (
 `uid` varchar(36) NOT NULL,
 `token` varchar(36),
 `expiry` DATETIME NOT NULL,
 PRIMARY KEY (`uid`),
 KEY `auth_api_users` (`uid`),
 CONSTRAINT `auth_api_users` FOREIGN KEY (`uid`) REFERENCES `api_users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;