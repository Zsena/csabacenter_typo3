<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_event',
	[
		'overrideLabel' => true
	],
	'event_tags',
	\DigitalZombies\Center\Domain\Model\Records\Event::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_event',
	[
		'withoutTab' => true
	]
);


\DigitalZombies\Center\Utility\InterestHelper::enhanceWithInterest(
	\DigitalZombies\Center\Domain\Model\Records\Event::TABLE_NAME,
	[],
	'interests',
	\DigitalZombies\Center\Domain\Model\Records\Event::TYPE
);