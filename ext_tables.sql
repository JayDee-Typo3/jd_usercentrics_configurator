CREATE TABLE tx_jdusercentricsconfigurator_domain_model_config (
	settings_id varchar(255) NOT NULL DEFAULT '',
	activate smallint(1) unsigned NOT NULL DEFAULT '0',
	use_footer_link smallint(1) unsigned NOT NULL DEFAULT '0',
	use_gtm smallint(1) unsigned NOT NULL DEFAULT '0',
	block_only text NOT NULL DEFAULT '',
	block_elements text NOT NULL DEFAULT ''
);
