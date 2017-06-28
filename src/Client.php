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

			$parameters = [
				'url' => $config[ 'url' ] || 'https://api.convertkit.com',
				'request.options' => [
					'query' => [
						'api_key' => $config[ 'api_key' ],
						'api_secret' => $config[ 'api_secret' ],
						'origin' => $config[ 'origin' ]
					]
				]
			];

			$client = new self( $parameters[ 'url' ], $parameters );
			$client->setDescription( ServiceDescription::factory( __DIR__ . '/service.json' ) );
			$client->setDefaultOption('headers/Content-Type', 'application/json');

			return $client;
		}

		public function getAllLists( $args = [], $returnRaw = false )
		{
			return $this->getResult( 'getAllLists', $args, $returnRaw );
		}

		public function addSubscriberToList( $formId, $email, $firstName = null, $tags = '', $fields = [], $args = [], $returnRaw = false )
		{
			$args[ 'formId' ] = $formId;
			$args[ 'email' ] = $email;

			if( isset( $firstName ) )
			{
				$args[ 'first_name' ] = $firstName;
			}

			if( !empty( $tags ) )
			{
				$args[ 'tags' ] = $tags;
			}

			if( !empty( $fields ) )
			{
				$args[ 'fields' ] = $fields;
			}

			return $this->getResult( 'addSubscriberToList', $args, $returnRaw );
		}

		public function getAllTags( $args = [], $returnRaw = false )
		{
			return $this->getResult( 'getAllTags', $args, $returnRaw );
		}

		public function createTag( $tagName, $args = [], $returnRaw = false )
		{
			$args[ 'name' ] = $tagName;

			return $this->getResult( 'createTag', $args, $returnRaw );
		}

		public function createMultipleTags()
		{
			/*
				update this function when Convert Kit adds this functionality
			*/
		}

		public function getCustomFields( $args = [], $returnRaw = false )
		{
			return $this->getResult( 'getCustomFields', $args, $returnRaw );
		}

		public function createCustomField( $fieldLabel, $args = [], $returnRaw = false )
		{
			$args[ 'label' ] = $fieldLabel;

			return $this->getResult( 'createCustomField', $args, $returnRaw );
		}

		public function createMultipleCustomFields()
		{
			/*
				update this function when Convert Kit adds this functionality
			*/
		}

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
