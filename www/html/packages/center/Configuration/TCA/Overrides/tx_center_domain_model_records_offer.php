<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	\DigitalZombies\Center\Domain\Model\Records\Offer::TABLE_NAME,
	[
		'overrideLabel' => true
	],
	'offer_tags',
	\DigitalZombies\Center\Domain\Model\Records\Offer::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_offer',
	[
		'withoutTab' => true
	]
);

\DigitalZombies\Center\Utility\InterestHelper::enhanceWithInterest(
	\DigitalZombies\Center\Domain\Model\Records\Offer::TABLE_NAME,
	[],
	'interests',
	\DigitalZombies\Center\Domain\Model\Records\Offer::TYPE
);