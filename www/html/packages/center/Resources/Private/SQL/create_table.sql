DROP TABLE IF EXISTS tx_center_domain_model_recordbase_new;

CREATE TABLE `tx_center_domain_model_recordbase_new` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `centers` int(11) NOT NULL DEFAULT '0',
  `reference_type` int(11) NOT NULL DEFAULT '0',
  `shop` int(11) NOT NULL DEFAULT '0',
  `center` int(11) NOT NULL DEFAULT '0',
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `teaser_video` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_image` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_image2` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_image3` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_format` int(10) unsigned NOT NULL DEFAULT '0',
  `teaser_abstract` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `service_icon` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `teaser_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tags` int(10) unsigned NOT NULL DEFAULT '0',
  `special_tags` int(10) unsigned NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumblob,
  `type_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `teaser_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `teaser_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `chain_store` int(10) unsigned NOT NULL DEFAULT '0',
  `chain_store_tags` int(10) unsigned NOT NULL DEFAULT '0',
  `global_service` int(10) unsigned NOT NULL DEFAULT '0',
  `content_showglobalservicedata` smallint(5) unsigned NOT NULL DEFAULT '0',
  `logo` int(10) unsigned NOT NULL DEFAULT '0',
  `positions` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_fallback_teaser` int(10) unsigned NOT NULL DEFAULT '0',
  `time_diff` int(10) unsigned NOT NULL DEFAULT '0',
  `type_sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `interests` int(10) unsigned NOT NULL DEFAULT '0',
  `page_icon` int(10) unsigned NOT NULL DEFAULT '0',
  `hide_in_app` int(10) unsigned NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  KEY `type` (`type_uid`),
  KEY `parent` (`pid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `language` (`l10n_parent`,`sys_language_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center,'tx_center_domain_model_records_news' as table_name, '' as label, teaser_image, teaser_video, teaser_image2, '0' as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_news' as type, type as teaser_category, tags, news_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_news', '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo, 0 as positions, '' as link, 0 as is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 30 as type_sorting, interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_news
WHERE deleted = 0 AND hidden = 0 AND title != '';

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center, 'tx_center_domain_model_records_job' as table_name, '' as label, teaser_image, '0' as teaser_video, '0' as teaser_image2,  '0' as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_job' as type, job_category as teaser_category, tags, job_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_job', '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo, 0 as positions, '' as link, 0 as is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 40 as type_sorting, 0 as interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_job
WHERE deleted = 0 AND hidden = 0 AND title != '';

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center, 'tx_center_domain_model_records_event' as table_name, '' as label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_event' as type, 'tx_center_domain_model_records_event' as teaser_category, tags, event_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_event', '--', uid) as type_uid,
teaser_date, teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo, 0 as positions, '' as link, 0 as is_fallback_teaser, CASE WHEN endtime > UNIX_TIMESTAMP() THEN CEIL(endtime / 86400) - CEIL(UNIX_TIMESTAMP() / 86400) ELSE 0 END as time_diff, 10 as type_sorting, interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_event
WHERE deleted = 0 AND hidden = 0 AND title != '';

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center, 'tx_center_domain_model_records_offer' as table_name, '' as label, teaser_image, teaser_video, teaser_image2, '0' as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_offer' as type, 'tx_center_domain_model_records_offer' as teaser_category, tags, offer_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_offer', '--', uid) as type_uid,
teaser_date as teaser_date, '' as teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo, 0 as positions, '' as link, 0 as is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 20 as type_sorting, interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_offer
WHERE deleted = 0 AND hidden = 0 AND title != '';

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center, 'tx_center_domain_model_records_coupon' as table_name, '' as label, teaser_image, teaser_video, teaser_image2, '0' as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_coupon' as type, 'tx_center_domain_model_records_coupon' as teaser_category, tags, coupon_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_coupon', '--', uid) as type_uid,
teaser_date as teaser_date, '' as teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo, 0 as positions, '' as link, 0 as is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 20 as type_sorting, interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_coupon
WHERE deleted = 0 AND hidden = 0 AND title != '' AND coupons_redeemed < fixed_amount;

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, 0 as centers, 0 as shop, 0 as reference_type, center as center, 'tx_center_domain_model_records_service' as table_name, '' as label, teaser_image as teaser_image, '0' as teaser_video, '0' as teaser_image2, '0' as teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_service' as type, 'tx_center_domain_model_records_service' as teaser_category, tags, service_tags as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_service', '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
0 as chain_store, 0 as chain_store_tags, global_service, content_showglobalservicedata, 0 as logo, positions as positions, '' as link, 0 as is_fallback_teaser, '0' as time_diff, 100 as type_sorting, 0 as interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_service
WHERE deleted = 0 AND hidden = 0 AND title != '';

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title,  0 as centers, 0 as shop, 0 as reference_type, center, 'tx_center_domain_model_records_contentteaser' as table_name, label, teaser_image, teaser_video, teaser_image2, '0' as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_contentteaser' as type, 'tx_center_domain_model_records_contentteaser' as teaser_category, tags, 0 as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_contentteaser', '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
0 as chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo,  0 as positions, link, is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 100 as type_sorting, 0 as interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_contentteaser
WHERE deleted = 0 AND hidden = 0 AND title != '';


INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, centers, shop, reference_type, center, 'tx_center_domain_model_records_banner' as table_name,  '' as label, teaser_image, '0' as teaser_video, '0' as teaser_image2, '0' as teaser_image3, 1 as teaser_format, '' as teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
'tx_center_domain_model_records_banner' as type, 'tx_center_domain_model_records_banner' as teaser_category, 0 as tags, 0 as special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, CONCAT('tx_center_domain_model_records_banner', '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo,  0 as positions, link, 0 as is_fallback_teaser, CASE WHEN UNIX_TIMESTAMP() > starttime THEN CEIL(UNIX_TIMESTAMP() / 86400) - CEIL(starttime / 86400) ELSE 0 END as time_diff, 100 as type_sorting, 0 as interests, '0' as page_icon, hide_in_app
FROM tx_center_domain_model_records_banner
WHERE deleted = 0 AND hidden = 0 AND title != '';


INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title, 0 as centers, 0 as shop, 0 as reference_type, center, 'pages' as table_name, '' as label, CASE WHEN pages.doktype = '135' THEN teaser_image_blog ELSE pages.logo END as teaser_image, '0' as teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden, starttime, endtime,
pages.doktype as type, pages.doktype as teaser_category, tags, CASE WHEN doktype = '135' THEN blog_tags WHEN doktype = '134' THEN gastro_tags WHEN doktype = '133' THEN shop_tags ELSE '' END as special_tags,
t3ver_state, t3ver_wsid, 0 AS l10n_parent, null as l10n_diffsource, 0 AS sys_language_uid, CONCAT(pages.doktype, '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
pages.chain_store, pages.chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, pages.logo, pages.positions, '' as link, 0 as is_fallback_teaser, '0' as time_diff, 100 as type_sorting, 0 as interests, '0' as page_icon, '0' as hide_in_app
FROM pages
WHERE doktype IN(133,134,135) AND pages.no_list = 0 AND deleted = 0 AND hidden = 0;

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT plo.uid, pages.pid, plo.title, 0 as centers, CASE WHEN pages.doktype = '134' OR pages.doktype = '133' THEN pages.uid ELSE 0 END as shop, 0 as reference_type, pages.center, 'pages' as table_name, '' as label, '0' as teaser_image, '0' as teaser_video,
pages.teaser_image2, pages.teaser_image3, pages.teaser_format,plo.teaser_abstract,  '0' as service_icon, plo.tstamp, pages.crdate,
plo.cruser_id, plo.deleted, plo.hidden, pages.starttime,
pages.endtime, pages.doktype as type, pages.doktype as teaser_category, pages.tags,
CASE WHEN pages.doktype = '135' THEN pages.blog_tags WHEN pages.doktype = '134' THEN pages.gastro_tags WHEN pages.doktype = '133' THEN pages.shop_tags ELSE '' END as special_tags,
plo.t3ver_state, plo.t3ver_wsid, plo.pid AS l10n_parent, plo.l10n_diffsource as l10n_diffsource, plo.sys_language_uid AS sys_language_uid, CONCAT(pages.doktype, '--', pages.uid) as type_uid,
pages.starttime as teaser_date, '' as teaser_time,
pages.chain_store, pages.chain_store_tags,0 as global_service, 0 as content_showglobalservicedata, pages.logo, pages.positions, '' as link, 0 as is_fallback_teaser, '0' as time_diff, 100 as type_sorting, 0 as interests, '0' as page_icon, '0' as hide_in_app
FROM pages plo
INNER JOIN pages ON pages.uid = plo.pid
WHERE pages.doktype IN(133,134,135) AND pages.no_list = 0
AND pages.deleted = 0 AND pages.hidden = 0 AND plo.deleted = 0 AND plo.hidden = 0;

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT uid, pid, title,  0 as centers, 0 as shop, 0 as reference_type, center, 'pages' as table_name, '' as label, teaser_image, teaser_video, teaser_image2 as teaser_image2, teaser_image3 as teaser_image3, teaser_format, teaser_abstract, '0' as service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime,
doktype as type, doktype as teaser_category, tags, 0 as special_tags,
t3ver_state, t3ver_wsid,  0 AS l10n_parent, null as l10n_diffsource, 0 AS sys_language_uid, CONCAT(pages.doktype, '--', uid) as type_uid,
starttime as teaser_date, '' as teaser_time,
0 as chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 as logo,  0 as positions, uid as link, 0 as is_fallback_teaser, '0' as time_diff, 100 as type_sorting, 0 as interests, pages.page_icon as page_icon, '0' as hide_in_app
FROM pages
WHERE doktype IN(1,3,4) AND deleted = 0 AND hidden = 0
AND title != '' AND teaser_abstract != '' AND teaser_image != 0;

INSERT INTO tx_center_domain_model_recordbase_new (uid, pid, title, centers, shop, reference_type, center, table_name, label, teaser_image, teaser_video, teaser_image2, teaser_image3, teaser_format, teaser_abstract, service_icon, tstamp,crdate,cruser_id, deleted, hidden,starttime, endtime, type, teaser_category, tags, special_tags,
t3ver_state, t3ver_wsid, l10n_parent, l10n_diffsource, sys_language_uid, type_uid,
teaser_date, teaser_time,
chain_store, chain_store_tags, global_service, content_showglobalservicedata, logo, positions, link, is_fallback_teaser, time_diff, type_sorting, interests, page_icon, hide_in_app)

SELECT plo.uid, pages.pid, plo.title, 0 as centers, 0 as shop, 0 as reference_type, pages.center, 'pages' as table_name, '' as label, plo.teaser_image as teaser_image, pages.teaser_video as teaser_video, plo.teaser_image2 as teaser_image2, plo.teaser_image3 as teaser_image3, pages.teaser_format, plo.teaser_abstract, '0' as service_icon, plo.tstamp, pages.crdate, plo.cruser_id, plo.deleted, plo.hidden, pages.starttime, pages.endtime,
pages.doktype as type, pages.doktype as teaser_category, pages.tags, 0 as special_tags,
plo.t3ver_state, plo.t3ver_wsid, plo.pid AS l10n_parent, plo.l10n_diffsource as l10n_diffsource, plo.sys_language_uid AS sys_language_uid, CONCAT(pages.doktype, '--', pages.uid) as type_uid,
pages.starttime as teaser_date, '' as teaser_time,
0 as chain_store, 0 as chain_store_tags, 0 as global_service, 0 as content_showglobalservicedata, 0 AS logo,  0 as positions, pages.uid as link, 0 as is_fallback_teaser, '0' as time_diff, 100 as type_sorting, 0 as interests, pages.page_icon as page_icon, '0' as hide_in_app
FROM pages plo
INNER JOIN pages ON pages.uid = plo.pid
WHERE pages.doktype IN(1,3,4)
AND pages.deleted = 0 AND pages.hidden = 0 AND plo.deleted = 0 AND plo.hidden = 0
AND plo.title != '' AND plo.teaser_abstract != '' AND (pages.teaser_image != 0);

RENAME TABLE tx_center_domain_model_recordbase to tx_center_domain_model_recordbase_old, tx_center_domain_model_recordbase_new to tx_center_domain_model_recordbase;
DROP TABLE tx_center_domain_model_recordbase_old;
