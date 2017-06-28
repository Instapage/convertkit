<?php

	namespace CSD\Convertkit;

	use Guzzle\Common\Collection;
	use Guzzle\Service\Client as Guzzle_Client;
	use Guzzle\Service\Description\ServiceDescription;

	class Client extends Guzzle_Client
	{
		// config accepts following parameters: api_key, api_secret, url and origin
		public static function factory( $config = [] )
		{

			$config = [
				'url' => 'https://api.convertkit.com',
				'request.options' => [
					'query' => [
						'api_key' => $config[ 'api_key' ],
						'api_secret' => $config[ 'api_secret' ],
						'origin' => $config[ 'origin' ]
					]
				]
			];

			$client = new self( $config['url'], $config );
			$client->setDescription( ServiceDescription::factory( __DIR__ . '/service.json' ) );
			$client->setDefaultOption('headers/Content-Type', 'application/json');

			return $client;
		}

		public function getAllLists( $args, $returnRaw )
		{
			return $this->getResult( 'getAllLists', $args, $returnRaw );
		}

		public function addSubscriberToList(){}

		public function getAllTags(){}

		public function createTag(){}

		public function createMultipleTags(){}

		public function getCustomFields(){}

		public function createCustomField(){}

		public function createMultopleCustomFields(){}

		private function getResult( $command, $args, $returnRaw )
		{
			$cmd = $this->getCommand( $command, $args );
			$cmd->prepare();

			if( $returnRaw )
			{
				return $cmd->getResponse()->getBody( true );
			}

			return $cmd->getResult();
		}
	}
