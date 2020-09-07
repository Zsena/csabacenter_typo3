<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_shop_chainstore',
	[
		'overrideLabel' => true,
	],
	'shop_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_shop_chainstore',
	[
		'overrideLabel' => true,
		'withoutTab' => true,
	],
	'gastro_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE
);