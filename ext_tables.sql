#
# Table structure for table 'tx_addresses_domain_model_address'
#
CREATE TABLE tx_addresses_domain_model_address (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  firstname tinytext NOT NULL,
  lastname tinytext NOT NULL,  
  gender tinytext NOT NULL,
  birthday int(11) DEFAULT '0' NOT NULL,
  title varchar(40) DEFAULT '' NOT NULL,
  email varchar(80) DEFAULT '' NOT NULL,
  phone varchar(30) DEFAULT '' NOT NULL,
  mobile varchar(30) DEFAULT '' NOT NULL,
  fax varchar(30) DEFAULT '' NOT NULL,
  www varchar(80) DEFAULT '' NOT NULL,
  address tinytext NOT NULL,
  building varchar(20) DEFAULT '' NOT NULL,
  room varchar(15) DEFAULT '' NOT NULL,
  company varchar(80) DEFAULT '' NOT NULL,
  city varchar(80) DEFAULT '' NOT NULL,
  zip varchar(20) DEFAULT '' NOT NULL,
  region varchar(100) DEFAULT '' NOT NULL,
  country varchar(30) DEFAULT '' NOT NULL,
  image tinyblob NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  description text NOT NULL,
  addressgroups int(11) DEFAULT '0' NOT NULL,
  marital_status int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY pid (pid,email)
);


#
# Table structure for table 'tx_addresses_domain_model_addressgroup'
#
CREATE TABLE tx_addresses_domain_model_addressgroup (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	description text NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_addresses_address_addressgroup_mm'
#
#
CREATE TABLE tx_addresses_address_addressgroup_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);
