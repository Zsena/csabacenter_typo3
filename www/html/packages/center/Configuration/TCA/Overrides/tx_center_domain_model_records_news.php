<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_news',
	[
		'overrideLabel' => true
	],
	'news_tags',
	\DigitalZombies\Center\Domain\Model\Records\News::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_news',
	[
		'withoutTab' => true
	]
);


\DigitalZombies\Center\Utility\InterestHelper::enhanceWithInterest(
	\DigitalZombies\Center\Domain\Model\Records\News::TABLE_NAME,
	[],
	'interests',
	\DigitalZombies\Center\Domain\Model\Records\News::TYPE
);