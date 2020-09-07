<?php

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_job',
	[
		'overrideLabel' => true
	],
	'job_tags',
	\DigitalZombies\Center\Domain\Model\Records\Job::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'tx_center_domain_model_records_job',
	[
		'withoutTab' => true
	]
);