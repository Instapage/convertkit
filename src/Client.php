<?php

	namespace CSD\Convertkit;

	use Guzzle\Common\Collection;
	use Guzzle\Service\Client as Guzzle_Client;
	use Guzzle\Service\Description\ServiceDescription;

	class Client extends Guzzle_Client
	{
		// config accepts following parameters: api_secret, url and origin
		public static function factory( $config = [] )
		{
			$url = 'https://api.convertkit.com';

			if( isset( $config[ 'url' ] ) )
			{
				$url = $config[ 'url' ];
			}

			$parameters = [
				'url' => $url,
				'request.options' => [
					'query' => [
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

		// required fields in data: form_id, email, fields. Optional: fields, first_name
		public function addSubscriberToList( $data, $args = [], $returnRaw = false )
		{
			$args[ 'formId' ] = $data[ 'form_id' ];
			$args[ 'email' ] = $data[ 'email' ];

			if( isset( $data[ 'first_name' ] ) )
			{
				$args[ 'first_name' ] = $data[ 'first_name' ];
			}

			if( !empty( $data[ 'tags' ] ) )
			{
				$args[ 'tags' ] = $data[ 'tags' ];
			}

			if( !empty( $data[ 'fields' ] ) )
			{
				$args[ 'fields' ] = $data[ 'fields' ];
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

		public function getSubscriptionsToForm( $formId, $args = [], $returnRaw = false )
		{
			$args[ 'formId' ] = $formId;

			return $this->getResult( 'getSubscriptionsToForm', $args, $returnRaw );
		}

		private function getResult( $command, $args, $returnRaw )
		{
			try
			{
				$cmd = $this->getCommand( $command, $args );
				$cmd->prepare();

				if( $returnRaw )
				{
					return $cmd->getResponse()->getBody( true );
				}

				return $cmd->getResult();
			}
			catch( \Exception $e )
			{
				$response = $e->getResponse();

				return [
					'success' => false,
					'status code' => $response->getStatusCode(),
					'reason' => $response->getReasonPhrase(),
				];
			}
		}
	}
