-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

CREATE TABLE `tl_module` (
  `et_securecode` varchar(20) NOT NULL default '',
  `et_template` varchar(50) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `tl_page` (
  `et_target` varchar(1) NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
