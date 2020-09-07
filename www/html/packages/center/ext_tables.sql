-- noinspection SqlNoDataSourceInspectionForFile

-- noinspection SqlDialectInspectionForFile

# noinspection SqlNoDataSourceInspectionForFile
#
# Table structure for table 'tx_center_domain_model_center_center'
#
CREATE TABLE tx_center_domain_model_center_center (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	objectid TINYTEXT,

	title varchar(255) DEFAULT '' NOT NULL,
	center_name varchar(255) DEFAULT '' NOT NULL,
	short_name varchar(255) DEFAULT '' NOT NULL,
	region int(11) DEFAULT '0' NOT NULL,
	communication_group int(11) DEFAULT '0' NOT NULL,
	communication_line int(11) DEFAULT '0' NOT NULL,
	header_variant int(11) DEFAULT '0' NOT NULL,
	levels int(11) DEFAULT '0' NOT NULL,
	wayfinder_activated tinyint(4) unsigned DEFAULT '0' NOT NULL,
	wayfinder_url varchar(255) DEFAULT '' NOT NULL,
	items int(11) DEFAULT '0' NOT NULL,

	address text,
	company text,
	phone varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	lng varchar(255) DEFAULT '' NOT NULL,
	lat varchar(255) DEFAULT '' NOT NULL,
	map_zoom int(11) DEFAULT '0' NOT NULL,
	title_postfix varchar(255) DEFAULT '' NOT NULL,
	override_coordinates tinyint(4) unsigned DEFAULT '0' NOT NULL,

	app_store_links int(11) DEFAULT '0' NOT NULL,
	social_channels int(11) DEFAULT '0' NOT NULL,

	payment int(11) DEFAULT '0' NOT NULL,
	payment_online_shop int(11) DEFAULT '0' NOT NULL,
	shipping int(11) DEFAULT '0' NOT NULL,

	logo int(11) DEFAULT '0' NOT NULL,
	logo_alt int(11) DEFAULT '0' NOT NULL,
	logo_email int(11) DEFAULT '0' NOT NULL,
	logo_products int(11) DEFAULT '0' NOT NULL,
	push_server_ios_topic varchar(255) DEFAULT '' NOT NULL,
	push_server_ios_authorization_key varchar(255) DEFAULT '' NOT NULL,
	push_server_android_topic varchar(255) DEFAULT '' NOT NULL,
	push_server_android_authorization_key varchar(255) DEFAULT '' NOT NULL,

	theme int(11) DEFAULT '0' NOT NULL,
	ga_center varchar(255) DEFAULT '' NOT NULL,
	ga_ece_account varchar(255) DEFAULT '' NOT NULL,
	gtm_ece_account varchar(255) DEFAULT '' NOT NULL,
	use_gtm_ece_account tinyint(4) unsigned DEFAULT '0' NOT NULL,
	facebook_pixel varchar(255) DEFAULT '' NOT NULL,
	page_id int(11) DEFAULT '0' NOT NULL,

	gallery int(11) DEFAULT '0' NOT NULL,

	country int(11) DEFAULT '0' NOT NULL,
	timezone int(11) DEFAULT '0' NOT NULL,
	show_footer_registration tinyint(4) DEFAULT '1' NOT NULL,

	show_darksite tinyint(4) unsigned DEFAULT '0' NOT NULL,
	darksite_title varchar(255) DEFAULT '' NOT NULL,
	darksite_text text,
	hide_openings tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hide_all_openings tinyint(4) unsigned DEFAULT '0' NOT NULL,

	subsidiary int(11) DEFAULT '0' NOT NULL,
	contactperson_dp int(11) DEFAULT '0' NOT NULL,

	login_activated int(11) DEFAULT '0' NOT NULL,
	login_activated_changed int(11) DEFAULT '0' NOT NULL,
	disable_login_in_web int(11) DEFAULT '0' NOT NULL,
	show_social_login int(11) DEFAULT '0' NOT NULL,

	coupon_no_login int(11) unsigned DEFAULT '0' NOT NULL,

	weekly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	yearly_schedule int(11) unsigned DEFAULT '0' NOT NULL,

	interest_list int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_centerlevel'
#
CREATE TABLE tx_center_domain_model_center_centerlevel (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	image int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	short_name varchar(15) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_payment'
#
CREATE TABLE tx_center_domain_model_center_payment (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,

	icon int(11) DEFAULT '0' NOT NULL,
	text varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_paymentonlineshop'
#
CREATE TABLE tx_center_domain_model_center_paymentonlineshop (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,

	icon int(11) DEFAULT '0' NOT NULL,
	text varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_shipping'
#
CREATE TABLE tx_center_domain_model_center_shipping (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,

	icon int(11) DEFAULT '0' NOT NULL,
	text varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_centerlevelposition'
#
CREATE TABLE tx_center_domain_model_center_centerlevelposition (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	object_position varchar(255) DEFAULT '' NOT NULL,
	center_level int(11) DEFAULT '0' NOT NULL,
	type int(11) unsigned DEFAULT '0' NOT NULL,
	shop int(11) unsigned DEFAULT '0' NOT NULL,
	service int(11) unsigned DEFAULT '0' NOT NULL,
	center int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_appstorelink'
#
CREATE TABLE tx_center_domain_model_center_appstorelink (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,
	url varchar(255) DEFAULT '' NOT NULL,
	type int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_center_socialchannel'
#
CREATE TABLE tx_center_domain_model_center_socialchannel (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,
	url varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_shop_chainstore'
#
CREATE TABLE tx_center_domain_model_shop_chainstore (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	logo int(11) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	description text ,
	meta_title varchar(255) DEFAULT '' NOT NULL,
	meta_description varchar(255) DEFAULT '' NOT NULL,
	keywords varchar(255) DEFAULT '' NOT NULL,

  phone varchar(255) DEFAULT '' NOT NULL,
  email varchar(255) DEFAULT '' NOT NULL,
  website varchar(255) DEFAULT '' NOT NULL,

  company varchar(255) DEFAULT '' NOT NULL,
  address varchar(255) DEFAULT '' NOT NULL,
  zip_city varchar(255) DEFAULT '' NOT NULL,

  #TAGGING
  shop_tags int(11) unsigned DEFAULT '0' NOT NULL,
	gastro_tags int(11) unsigned DEFAULT '0' NOT NULL,
	tags int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
#
# Table structure for table 'tx_center_domain_model_records_job'
#
CREATE TABLE tx_center_domain_model_records_job (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,
	content_text text,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_downloadlink varchar(255) DEFAULT '' NOT NULL,
	content_downloadlinktext varchar(255) DEFAULT '' NOT NULL,
	job_category varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	job_tags int(11) unsigned DEFAULT '0' NOT NULL,

  #Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_center_domain_model_records_news'
#
CREATE TABLE tx_center_domain_model_records_news (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	type varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,
	content_prologue text ,
	content_epilogue text ,
	content_stagemedia int(11) unsigned DEFAULT '0' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_googleplay varchar(255) DEFAULT '' NOT NULL,
	content_applestore varchar(255) DEFAULT '' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	content_video int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_downloadlink varchar(255) DEFAULT '' NOT NULL,
	content_downloadlinktext varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,
	top_in_app int(11) DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	news_tags int(11) unsigned DEFAULT '0' NOT NULL,

  #Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	#Interests
	interests int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_center_mm'
#
CREATE TABLE tx_center_domain_model_records_center_mm (

	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,

	KEY uid_local_foreign (uid_local,uid_foreign),
	KEY uid_foreign_tablefield (uid_foreign,tablenames(40),sorting_foreign)

);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_center_center int(11) unsigned DEFAULT '0' NOT NULL,
	logo int(11) DEFAULT '0' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
	shop_list_type VARCHAR (255) DEFAULT '' NOT NULL,
	shop_name varchar(255) DEFAULT '' NOT NULL,
	positions int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image3 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,
	content_headline varchar(255) DEFAULT '' NOT NULL,
	content_text text,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	weekly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	yearly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	publishing_date int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image_blog int(11) unsigned DEFAULT '0' NOT NULL,
	page_icon int(11) unsigned DEFAULT '0' NOT NULL,

	chain_store_contact int(11) unsigned DEFAULT '0' NOT NULL,
	chain_store_text int(11) unsigned DEFAULT '0' NOT NULL,
	chain_store_tags int(11) unsigned DEFAULT '0' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
  email varchar(255) DEFAULT '' NOT NULL,
  website varchar(255) DEFAULT '' NOT NULL,

  no_list int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	shop_tags int(11) unsigned DEFAULT '0' NOT NULL,
	gastro_tags int(11) unsigned DEFAULT '0' NOT NULL,
	blog_tags int(11) unsigned DEFAULT '0' NOT NULL,
	service_tag int(11) unsigned DEFAULT '0' NOT NULL,

	hide_in_app int(11) DEFAULT '0' NOT NULL,
	app_key varchar(255) DEFAULT '' NOT NULL,
	print_pdf_link int(11) DEFAULT '0' NOT NULL,

	company varchar(255) DEFAULT '' NOT NULL,
  address varchar(255) DEFAULT '' NOT NULL,
  zip_city varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	tx_center_center int(11) unsigned DEFAULT '0' NOT NULL,
	logo int(11) DEFAULT '0' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
	shop_name varchar(255) DEFAULT '' NOT NULL,
	positions int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image3 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,
	content_headline varchar(255) DEFAULT '' NOT NULL,
	content_text text,
	gallery int(11) DEFAULT '0' NOT NULL,
	weekly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	yearly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	publishing_date int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image_blog int(11) unsigned DEFAULT '0' NOT NULL,
	chain_store_text int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	shop_tags int(11) unsigned DEFAULT '0' NOT NULL,
	gastro_tags int(11) unsigned DEFAULT '0' NOT NULL,
	blog_tags int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_center_domain_model_misc_gallery'
#
CREATE TABLE tx_center_domain_model_misc_gallery (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center int(11) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	images int(11) DEFAULT '0' NOT NULL,
	items int(11) DEFAULT '0' NOT NULL,
  title_intern varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_center_domain_model_misc_gallery_record_mm'
#
CREATE TABLE tx_center_domain_model_misc_gallery_record_mm (

  id int(11) PRIMARY KEY auto_increment,

	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(255) DEFAULT '' NOT NULL,
  fieldname varchar(255) DEFAULT '' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)

);

#
# Table structure for table 'tx_center_domain_model_misc_contactperson'
#
CREATE TABLE tx_center_domain_model_misc_contactperson (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	first_name varchar(255) DEFAULT '' NOT NULL,
	last_name varchar(255) DEFAULT '' NOT NULL,
	global int(11) DEFAULT '0' NOT NULL,
	company_name varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	function varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	address text ,
	website varchar(255) DEFAULT '' NOT NULL,
	responsibilities varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,
	salutation int(11) unsigned DEFAULT '1' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_direction'
#
CREATE TABLE tx_center_domain_model_misc_direction (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	page int(11) unsigned DEFAULT '0' NOT NULL,
	center int(11) unsigned DEFAULT '0' NOT NULL,
	function varchar(255) DEFAULT '' NOT NULL,
	icon varchar(255) DEFAULT '' NOT NULL,
	sorting  int(11) unsigned DEFAULT '0' NOT NULL,
	button_text varchar(255) DEFAULT '' NOT NULL,

	long varchar(255) DEFAULT '' NOT NULL,
	lat varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_country'
#
CREATE TABLE tx_center_domain_model_misc_country (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	timezones int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_timezone'
#
CREATE TABLE tx_center_domain_model_misc_timezone (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_country_tz_mm'
#
CREATE TABLE tx_center_domain_model_misc_country_tz_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)

);

#
# Table structure for table 'tx_center_domain_model_openinghours_dailyhours'
#
CREATE TABLE tx_center_domain_model_openinghours_dailyhours (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	day_of_week int(11) unsigned DEFAULT '0' NOT NULL,
	from int(11) unsigned DEFAULT '0' NOT NULL,
	till int(11) unsigned DEFAULT '0' NOT NULL,
	closed int(11) unsigned DEFAULT '0' NOT NULL,
	from_ext int(11) unsigned DEFAULT '0' NOT NULL,
	till_ext int(11) unsigned DEFAULT '0' NOT NULL,
	parent int(11) unsigned DEFAULT '0' NOT NULL,
	parent_table varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_openinghours_yearlyschedule'
#
CREATE TABLE tx_center_domain_model_openinghours_yearlyschedule (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	year int(11) unsigned DEFAULT '0' NOT NULL,
	holidays int(11) unsigned DEFAULT '0' NOT NULL,
	special_closing_days int(11) unsigned DEFAULT '0' NOT NULL,
	parent int(11) unsigned DEFAULT '0' NOT NULL,
	parent_table varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_center_domain_model_openinghours_holiday'
#
CREATE TABLE tx_center_domain_model_openinghours_holiday (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	country int(11) unsigned DEFAULT '0' NOT NULL,
	closing_day int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_center_domain_model_openinghours_specialclosingday'
#
CREATE TABLE tx_center_domain_model_openinghours_specialclosingday (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	schedule int(11) unsigned DEFAULT '0' NOT NULL,
	closing_day int(11) unsigned DEFAULT '0' NOT NULL,
	from int(11) unsigned DEFAULT '0' NOT NULL,
	till int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_openinghurs_shedule_holiday_mm'
#
CREATE TABLE tx_center_domain_model_openinghurs_shedule_holiday_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)

);

#
# Table structure for table 'sys_file'
#
CREATE TABLE sys_file (
	tx_center_svg_processed int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_center_domain_model_records_event'
#
CREATE TABLE tx_center_domain_model_records_event (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,
	location varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,

	content_text text,
	content_prologue text,
	content_epilogue text,
	content_stagemedia int(11) unsigned DEFAULT '0' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	content_video int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_downloadlink varchar(255) DEFAULT '' NOT NULL,
	content_downloadlinktext varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,
	top_in_app int(11) DEFAULT '0' NOT NULL,

	detail_title varchar(255) DEFAULT '' NOT NULL,
	detail_date varchar(255) DEFAULT '' NOT NULL,
	detail_time varchar(255) DEFAULT '' NOT NULL,

	event_showical tinyint(4) unsigned DEFAULT '0' NOT NULL,
	event_starttime int(11) unsigned DEFAULT '0' NOT NULL,
	event_endtime int(11) unsigned DEFAULT '0' NOT NULL,

	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image3 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	teaser_date varchar(255) DEFAULT '' NOT NULL,
	teaser_time varchar(255) DEFAULT '' NOT NULL,

	# Tab Seo
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,

	# Tab Social Media
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	event_tags int(11) unsigned DEFAULT '0' NOT NULL,

  #Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	#Interests
	interests int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_offer'
#
CREATE TABLE tx_center_domain_model_records_offer (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,

	# Tab allgemein
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,

	# Tab Content
	content_text text,
	content_stagemedia int(11) unsigned DEFAULT '0' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	offer_content_link_to_all_offers varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	detail_date varchar(255) DEFAULT '' NOT NULL,

	# Tab Teaser
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	teaser_date varchar(255) DEFAULT '' NOT NULL,

	# Tab Seo
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,

	# Tab Social Media
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	offer_tags int(11) unsigned DEFAULT '0' NOT NULL,

	#Interests
	interests int(11) unsigned DEFAULT '0' NOT NULL,

	#Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,
	top_in_app int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_coupon'
#
CREATE TABLE tx_center_domain_model_records_coupon (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,

	# Tab allgemein
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,

	# Tab Content
	content_text text,
	content_stagemedia int(11) unsigned DEFAULT '0' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	image_redeem int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	detail_date varchar(255) DEFAULT '' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,
	top_in_app int(11) DEFAULT '0' NOT NULL,

	# Tab Teaser
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	teaser_date varchar(255) DEFAULT '' NOT NULL,

	# Tab Seo
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,

	# Tab Social Media
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	coupon_tags int(11) unsigned DEFAULT '0' NOT NULL,

	#Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	#Interests
	interests int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	coupon_view int(11) unsigned DEFAULT '0' NOT NULL,
	coupons_redeemed int(11) unsigned DEFAULT '0' NOT NULL,
	fixed_amount int(11) unsigned DEFAULT '0' NOT NULL,
	valid_coupon_message text,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_coupons_user'
#
CREATE TABLE tx_center_domain_model_coupons_user (
  uid int(11) DEFAULT '0' NOT NULL auto_increment,
	uid_coupon int(11) DEFAULT '0' NOT NULL,
	uid_user int(11) DEFAULT '0' NOT NULL,
	PRIMARY KEY (uid),
);

#
# Table structure for table 'tx_center_domain_model_records_service'
#
CREATE TABLE tx_center_domain_model_records_service (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	alternative_title varchar(255) DEFAULT '' NOT NULL,
	weekly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	yearly_schedule int(11) unsigned DEFAULT '0' NOT NULL,
	content_showglobalservicedata tinyint(4) unsigned DEFAULT '0' NOT NULL,
	content_stagemedia int(11) unsigned DEFAULT '0' NOT NULL,
	content_headline varchar(255) DEFAULT '' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_googleplay varchar(255) DEFAULT '' NOT NULL,
	content_applestore varchar(255) DEFAULT '' NOT NULL,
	content_text text,
	center int(11) DEFAULT '0' NOT NULL,
	positions int(11) DEFAULT '0' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	content_video int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_downloadlink varchar(255) DEFAULT '' NOT NULL,
	content_downloadlinktext varchar(255) DEFAULT '' NOT NULL,
	global_service int(11) DEFAULT '0' NOT NULL,
	service_link varchar(255) DEFAULT '' NOT NULL,
	service_link_text varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	service_247 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	own_openings int(11) DEFAULT '0' NOT NULL,
	service_icon int(11) unsigned DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,

	elevator int(11) DEFAULT '0' NOT NULL,
	# Tab Seo
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,

	# Tab Social Media
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) unsigned DEFAULT '0' NOT NULL,

	# Tab Teaser
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,

	#Tab Contact
	contact int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	service_tags int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_contentteaser'
#
CREATE TABLE tx_center_domain_model_records_contentteaser (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	type varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	label varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	is_fallback_teaser int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,
	top_in_app int(11) DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_tag'
#
CREATE TABLE tx_center_domain_model_misc_tag (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
  	service_category_icon int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob NOT NULL,

	title tinytext NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,
	items int(11) DEFAULT '0' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY tag_parent (parent),
	KEY tag_list (pid,deleted,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_misc_tag_record_mm'
#
CREATE TABLE tx_center_domain_model_misc_tag_record_mm (

	id int(11) PRIMARY KEY auto_increment,

	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	fieldname varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local_foreign (uid_local,uid_foreign),
	KEY uid_foreign_tablefield (uid_foreign,tablenames(40),fieldname(3),sorting_foreign)
);

#
# Table structure for table 'tx_center_domain_model_misc_headlines'
#
CREATE TABLE tx_center_domain_model_misc_headlines (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	additional_shops varchar(255) DEFAULT '' NOT NULL,
	additional_events varchar(255) DEFAULT '' NOT NULL,
	additional_offers varchar(255) DEFAULT '' NOT NULL,
	gallery varchar(255) DEFAULT '' NOT NULL,
	center int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_easteregg_baserule'
#
CREATE TABLE tx_center_domain_model_easteregg_baserule (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	markup_to_replace text,
	image_folder varchar(255) DEFAULT '' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_easteregg_easteregg'
#
CREATE TABLE tx_center_domain_model_easteregg_easteregg (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	base_rule int(11) unsigned DEFAULT '0' NOT NULL,
	center int(11) unsigned DEFAULT '0' NOT NULL,
	word_to_hide varchar(255) DEFAULT '' NOT NULL,
	pages varchar(255) DEFAULT '' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_banner'
#
CREATE TABLE tx_center_domain_model_records_banner (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
	chain_store int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_records_globalservice'
#
CREATE TABLE tx_center_domain_model_records_globalservice (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	internal_title varchar(255) DEFAULT '' NOT NULL,
	content_abstract varchar(255) DEFAULT '' NOT NULL,
	content_text text,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	content_video int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfile int(11) unsigned DEFAULT '0' NOT NULL,
	content_downloadfiletext varchar(255) DEFAULT '' NOT NULL,
	content_downloadlink varchar(255) DEFAULT '' NOT NULL,
	content_downloadlinktext varchar(255) DEFAULT '' NOT NULL,
	service_link varchar(255) DEFAULT '' NOT NULL,
	service_link_text varchar(255) DEFAULT '' NOT NULL,
	content_gallery int(11) DEFAULT '0' NOT NULL,
	service_icon int(11) unsigned DEFAULT '0' NOT NULL,

	#Tagging
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	service_tags int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	hide_in_app int(11) DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_interest_interest'
#
CREATE TABLE tx_center_domain_model_interest_interest (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob NOT NULL,

	title tinytext NOT NULL,
	items int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY tag_list (pid,deleted,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_interest_interestlabel'
#
CREATE TABLE tx_center_domain_model_interest_interestlabel (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob NOT NULL,

	label tinytext NOT NULL,
	interest int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY tag_list (pid,deleted,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_interest_interestlist'
#
CREATE TABLE tx_center_domain_model_interest_interestlist (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	interests int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY tag_list (pid,deleted,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_interest_interestlist_interest_mm'
#
CREATE TABLE tx_center_domain_model_interest_il_interest_mm (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_interest_interest_record_mm'
#
CREATE TABLE tx_center_domain_model_interest_interest_record_mm (

	id int(11) PRIMARY KEY auto_increment,

	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	tablenames varchar(255) DEFAULT '' NOT NULL,
	fieldname varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local_foreign (uid_local,uid_foreign),
	KEY uid_foreign_tablefield (uid_foreign,tablenames(40),fieldname(3),sorting_foreign)
);

#
# Table structure for table 'tx_center_domain_model_appconfig_alertmessage'
#
CREATE TABLE tx_center_domain_model_appconfig_alertmessage (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	alert_id int(11) unsigned DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	internal_title varchar(255) DEFAULT '' NOT NULL,
	body_text text,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_appconfig_nativepage'
#
CREATE TABLE tx_center_domain_model_appconfig_nativepage (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	internal_title varchar(255) DEFAULT '' NOT NULL,
	body_text text,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_appconfig_extranavigationitem'
#
CREATE TABLE tx_center_domain_model_appconfig_extranavigationitem (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	app_config int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_appconfig_tabbaricon'
#
CREATE TABLE tx_center_domain_model_appconfig_tabbaricon (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	icon_name varchar(255) DEFAULT '' NOT NULL,
	android_icon int(11) unsigned DEFAULT '0' NOT NULL,
	android_active_icon int(11) unsigned DEFAULT '0' NOT NULL,
	ios_icon int(11) unsigned DEFAULT '0' NOT NULL,
	ios_active_icon int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_appconfig_tabbaritem'
#
CREATE TABLE tx_center_domain_model_appconfig_tabbaritem (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	icon int(11) unsigned DEFAULT '0' NOT NULL,
	page_id int(11) unsigned DEFAULT '0' NOT NULL,
	app_config int(11) unsigned DEFAULT '0' NOT NULL,
	role varchar(255) DEFAULT '' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_appconfig_config'
#
CREATE TABLE tx_center_domain_model_appconfig_config (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	center int(11) unsigned DEFAULT '0' NOT NULL,
	is_default int(11) unsigned DEFAULT '0' NOT NULL,
	alert_messages int(11) unsigned DEFAULT '0' NOT NULL,
	extra_navigation_items int(11) unsigned DEFAULT '0' NOT NULL,
	native_pages_title varchar(255) DEFAULT '' NOT NULL,
	native_pages int(11) unsigned DEFAULT '0' NOT NULL,
	tab_bar_items int(11) unsigned DEFAULT '0' NOT NULL,
	meta_navigation_items int(11) unsigned DEFAULT '0' NOT NULL,
	stage_image int(11) unsigned DEFAULT '0' NOT NULL,
	logo int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_center_domain_model_appconfig_conf_am_mm'
#
CREATE TABLE tx_center_domain_model_appconfig_conf_am_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_center_domain_model_appconfig_conf_np_mm'
#
CREATE TABLE tx_center_domain_model_appconfig_conf_np_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


### MIGRATION FIELDS:

CREATE TABLE tx_center_domain_model_center_center (
  target_pid INT(11) DEFAULT 0 NOT NULL

);

CREATE TABLE pages (
  assoc_to_center INT(11) DEFAULT 0 NOT NULL,
  root_page_uid INT(11) DEFAULT 0 NOT NULL,
  migrated_from INT(11) DEFAULT 0 NOT NULL,
  old_id INT(11) NOT NULL DEFAULT 0
);

CREATE TABLE tt_content (
  migrated_from INT(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_center_domain_model_records_job(
  old_id INT(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_center_domain_model_records_event (
  old_id INT(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_center_domain_model_records_offer (
 old_id INT(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_center_domain_model_records_service (
 old_id INT(11) DEFAULT 0 NOT NULL
);

CREATE TABLE tx_center_domain_model_shop_chainstore (
  old_id INT(11) NOT NULL DEFAULT 0
);

CREATE TABLE pages_language_overlay (
  old_id INT(11) NOT NULL DEFAULT 0
);

CREATE TABLE sys_file_reference (
  migrated INT(11) DEFAULT 0 NOT NULL
);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  interests int(11) DEFAULT 0 NOT NULL
);

#
# Table structure for table 'tx_center_domain_model_misc_subsidiary'
#
CREATE TABLE tx_center_domain_model_misc_subsidiary (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	data_protection_lg_company varchar(255) DEFAULT '' NOT NULL,
	data_protection_lg_street varchar(255) DEFAULT '' NOT NULL,
	data_protection_lg_city varchar(255) DEFAULT '' NOT NULL,
	data_protection_lg_phone varchar(255) DEFAULT '' NOT NULL,
	data_protection_lg_fax varchar(255) DEFAULT '' NOT NULL,
	data_protection_lg_email varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_misc_contactperson_dp'
#
CREATE TABLE tx_center_domain_model_misc_contactpersondp (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	data_protection_db_name varchar(255) DEFAULT '' NOT NULL,
	data_protection_db_company varchar(255) DEFAULT '' NOT NULL,
	data_protection_db_street varchar(255) DEFAULT '' NOT NULL,
	data_protection_db_city varchar(255) DEFAULT '' NOT NULL,
	data_protection_db_phone varchar(255) DEFAULT '' NOT NULL,
	data_protection_db_email varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_center_domain_model_recordbase'
#
CREATE TABLE tx_center_domain_model_recordbase (

	uid int(11) DEFAULT '0' NOT NULL,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	centers int(11) DEFAULT '0' NOT NULL,
	shop int(11) DEFAULT '0' NOT NULL,
  reference_type int(11) DEFAULT '0' NOT NULL,
	center int(11) DEFAULT '0' NOT NULL,
	table_name varchar(255) DEFAULT '' NOT NULL,
	label varchar(255) DEFAULT '' NOT NULL,
	teaser_video int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image2 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_image3 int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_format int(11) unsigned DEFAULT '0' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	service_icon int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	teaser_category varchar(255) DEFAULT '' NOT NULL,
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	special_tags int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

  type_uid varchar(255) DEFAULT '' NOT NULL,
	teaser_date varchar(255) DEFAULT '' NOT NULL,
	teaser_time varchar(255) DEFAULT '' NOT NULL,
	chain_store int(11) unsigned DEFAULT '0' NOT NULL,
	chain_store_tags int(11) unsigned DEFAULT '0' NOT NULL,
	global_service int(11) unsigned DEFAULT '0' NOT NULL,
	content_showglobalservicedata tinyint(4) unsigned DEFAULT '0' NOT NULL,
	logo int(11) unsigned DEFAULT '0' NOT NULL,
	positions int(11) unsigned DEFAULT '0' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	is_fallback_teaser int(11) unsigned DEFAULT '0' NOT NULL,

	time_diff int(11) unsigned DEFAULT '0' NOT NULL,
	type_sorting int(11) unsigned DEFAULT '0' NOT NULL,
	interests int(11) unsigned DEFAULT '0' NOT NULL,
	page_icon int(11) unsigned DEFAULT '0' NOT NULL,
	hide_in_app int(11) unsigned DEFAULT '0' NOT NULL,

	KEY type (type_uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
#
# Table structure for table 'tx_center_domain_model_bookmarks'
#
CREATE TABLE tx_center_domain_model_bookmarks (
	uid int(11) NOT NULL auto_increment,
	user_id int(11) DEFAULT '0' NOT NULL,
	center_id int(11) DEFAULT '0' NOT NULL,
	item_id int(11) DEFAULT '0' NOT NULL,
	tablename varchar(255) DEFAULT '' NOT NULL,
	bookmark_date int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
);

#
# Table structure for table 'tx_center_domain_model_pushnotification'
#
CREATE TABLE tx_center_domain_model_pushnotification (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	push_date DATETIME DEFAULT CURRENT_TIMESTAMP,
	push_time int(11) unsigned DEFAULT NULL,
	center int(11) unsigned DEFAULT NULL,
	linked_element varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	text text,
	delivery_type smallint(5) unsigned DEFAULT '0' NOT NULL,
	actual_delivery_date DATETIME DEFAULT NULL,
	marked_for_delivery smallint(5) unsigned DEFAULT '0' NOT NULL,
	type varchar(255) NOT NULL,
	is_test int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
) COLLATE utf8mb4_unicode_ci CHARACTER SET=utf8mb4;

#
# Table structure for table 'tx_center_domain_model_pushnotification_center_mm'
#
CREATE TABLE tx_center_domain_model_pushnotification_center_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	foreign_sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_center_domain_model_faqs_sections'
#
CREATE TABLE tx_center_domain_model_faqs_sections (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center_id int(11) DEFAULT '0' NOT NULL,
	section_name text,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_faqs'
#
CREATE TABLE tx_center_domain_model_faqs (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	center_id int(11) DEFAULT '0' NOT NULL,
	section_id int(11) DEFAULT '0' NOT NULL,
	question text,
	answer text,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_project_downloadbutton'
#
CREATE TABLE tx_center_domain_model_project_downloadbutton (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	icon varchar(255) DEFAULT '' NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);


#
# Table structure for table 'tx_center_domain_model_project_tablerow'
#
CREATE TABLE tx_center_domain_model_project_tablerow (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	text varchar(255) DEFAULT '' NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_project_slide'
#
CREATE TABLE tx_center_domain_model_project_slide (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	subtitle varchar(255) DEFAULT '' NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,
	media int(11) DEFAULT '0' NOT NULL,
	media_poster int(11) DEFAULT '0' NOT NULL,
	invert_color smallint(5) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_project_table'
#
CREATE TABLE tx_center_domain_model_project_table (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	table_rows int(11) DEFAULT '0' NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_center_domain_model_project_reference'
#
CREATE TABLE tx_center_domain_model_project_reference (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	slides int(11) DEFAULT '0' NOT NULL,
	teaser_title varchar(255) DEFAULT '' NOT NULL,
	teaser_abstract varchar(255) DEFAULT '' NOT NULL,
	teaser_customer varchar(255) DEFAULT '' NOT NULL,
	teaser_image int(11) DEFAULT '0' NOT NULL,
	mission_logo int(11) DEFAULT '0' NOT NULL,
	mission_copy text,
	mission_text text,
	implementation_copy text,
	hero_image int(11) DEFAULT '0' NOT NULL,
	images int(11) DEFAULT '0' NOT NULL,
	download_buttons int(11) DEFAULT '0' NOT NULL,
	seo_title varchar(255) DEFAULT '' NOT NULL,
	seo_description varchar(255) DEFAULT '' NOT NULL,
	og_image int(11) DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description varchar(255) DEFAULT '' NOT NULL,
	reference_tags int(11) DEFAULT '0' NOT NULL,
	tables int(11) DEFAULT '0' NOT NULL,
	related_references int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

CREATE TABLE tx_center_domain_model_project_reference_reference_mm (

  uid_local       int(11) DEFAULT '0' NOT NULL,
  uid_foreign     int(11) DEFAULT '0' NOT NULL,
  sorting         int(11) DEFAULT '0' NOT NULL,
  sorting_foreign int(11) DEFAULT '0' NOT NULL,

  KEY uid_local_foreign (uid_local, uid_foreign),
  KEY uid_foreign_tablefield (uid_foreign, sorting_foreign)
);
