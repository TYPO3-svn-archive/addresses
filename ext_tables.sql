#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'be_users'
#
CREATE TABLE be_users (
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_addresses_domain_model_person'
#
CREATE TABLE tx_addresses_domain_model_person (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,

	type tinytext NOT NULL,
	gender tinytext NOT NULL,
	status int(11) unsigned DEFAULT '0' NOT NULL,
	first_name tinytext NOT NULL,
	last_name tinytext NOT NULL,
	marital_status tinytext NOT NULL,
	title varchar(128) DEFAULT '' NOT NULL,
	birth_date int(11) DEFAULT '0' NOT NULL,
	birth_place tinytext NOT NULL,
	death_date int(11) DEFAULT '0' NOT NULL,
	death_place tinytext NOT NULL,
	nationality tinytext NOT NULL,
	religion tinytext NOT NULL,
	preferred_language varchar(40) DEFAULT '' NOT NULL,
	remarks text NOT NULL,
	fe_user int(11) DEFAULT '0' NOT NULL,
	fe_users int(11) DEFAULT '0' NOT NULL,
	be_user int(11) DEFAULT '0' NOT NULL,
	be_users int(11) DEFAULT '0' NOT NULL,

	numbers int(11) DEFAULT '0' NOT NULL,
	emails int(11) DEFAULT '0' NOT NULL,
	websites int(11) DEFAULT '0' NOT NULL,
	addresses int(11) DEFAULT '0' NOT NULL,
	images int(11) DEFAULT '0' NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY pid (pid)
);

#
# Table structure for table 'tx_addresses_domain_model_organization'
#
CREATE TABLE tx_addresses_domain_model_organization (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	type tinytext NOT NULL,
	name tinytext NOT NULL,
	remarks text NOT NULL,

	sectors int(11) DEFAULT '0' NOT NULL,
	numbers int(11) DEFAULT '0' NOT NULL,
	emails int(11) DEFAULT '0' NOT NULL,
	websites int(11) DEFAULT '0' NOT NULL,
	addresses int(11) DEFAULT '0' NOT NULL,
	images int(11) DEFAULT '0' NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY pid (pid)
);
	

#
# Table structure for table 'tx_addresses_domain_model_tag'
#

CREATE TABLE tx_addresses_domain_model_tag (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	upuser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	tagtype tinyint(3) DEFAULT '0' NOT NULL,
	category int(11) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	alternative_name tinytext NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,
	tag int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

#
# Table structure for table 'tx_addresses_domain_model_entity_tag_mm'
#

CREATE TABLE tx_addresses_domain_model_entity_tag_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	local_table varchar(128) DEFAULT '' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablenames varchar(128) DEFAULT '' NOT NULL,
	pid_foreign int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_addresses_domain_model_number'
#
CREATE TABLE tx_addresses_domain_model_number (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	label tinytext NOT NULL,
	type tinytext NOT NULL,
	phone_number tinytext NOT NULL,
	nature tinytext NOT NULL,
	standard tinyint(3) unsigned DEFAULT '0' NOT NULL,
	country int(11) unsigned DEFAULT '0' NOT NULL,
	area_code tinytext NOT NULL,
	extension tinytext NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_person (person)
	KEY uid_foreign_organization (organization)
);

#
# Table structure for table 'tx_addresses_domain_model_email'
#
CREATE TABLE tx_addresses_domain_model_email (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	label tinytext NOT NULL,
	type tinytext NOT NULL,
	email_address varchar(80) DEFAULT '' NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_person (person)
	KEY uid_foreign_organization (organization)
);

#
# Table structure for table 'tx_addresses_domain_model_sector'
#
CREATE TABLE tx_addresses_domain_model_sector (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	label tinytext NOT NULL,
	name varchar(80) DEFAULT '' NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_organization (organization)
);

#
# Table structure for table 'tx_addresses_domain_model_website'
#
CREATE TABLE tx_addresses_domain_model_website (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	label tinytext NOT NULL,
	type tinytext NOT NULL,
	website varchar(80) DEFAULT '' NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_person (person)
	KEY uid_foreign_organization (organization)
);

#
# Table structure for table 'tx_addresses_domain_model_address'
#
CREATE TABLE tx_addresses_domain_model_address (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	type tinytext NOT NULL,
	nature tinytext NOT NULL,
	label tinytext NOT NULL,
	street tinytext NOT NULL,
	street_number tinytext NOT NULL,
	building varchar(20) DEFAULT '' NOT NULL,
	room varchar(15) DEFAULT '' NOT NULL,
	postal_code varchar(20) DEFAULT '' NOT NULL,
	locality tinytext NOT NULL,
	region varchar(100) DEFAULT '' NOT NULL,
	country varchar(30) DEFAULT '' NOT NULL,
	latitude decimal(24,14) DEFAULT '0.00000000000000' NOT NULL,
	longitude decimal(24,14) DEFAULT '0.00000000000000' NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_person (person)
	KEY uid_foreign_organization (organization)
);

#
# Table structure for table 'tx_addresses_domain_model_image'
#
CREATE TABLE tx_addresses_domain_model_image (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	upuser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	person int(11) unsigned DEFAULT '0' NOT NULL,
	organization int(11) unsigned DEFAULT '0' NOT NULL,
	label tinytext NOT NULL,
	type tinytext NOT NULL,
	file_name tinyblob NOT NULL,
	remarks text NOT NULL,
	tags int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY uid_foreign_person (person)
	KEY uid_foreign_organization (organization)
);
