--
-- Table structure for table `tz_members`
--
use tcmks;

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `usr` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `pass` varchar(32) collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `regIP` varchar(15) collate utf8_unicode_ci NOT NULL default '',
  `real_name` varchar(15) collate utf8_unicode_ci default '',
  `job` varchar(255) collate utf8_unicode_ci default '',
  `profile` varchar(1000) collate utf8_unicode_ci default '',
  `icon` varchar(255) collate utf8_unicode_ci default '',
  `dt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `usr` (`usr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;