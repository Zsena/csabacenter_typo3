<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_service',
	[
		'overrideLabel' => true,
	],
	'service_tags',
	\DigitalZombies\Center\Domain\Model\Records\Service::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_service',
	[
		'withoutTab' => true
	]
);