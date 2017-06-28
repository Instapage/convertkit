<?php
	require __DIR__.'/vendor/autoload.php';

	use CSD\Convertkit\Client as Convertkit_Client;

	class Test
	{
		public function __construct()
		{
			$this->api_key = '';
			$this->api_secret = '';
			$this->origin = 'instapage';
		}

		private function prepareCredentials()
		{
			return [
				'api_key' => $this->api_key,
				'api_secret' => $this->api_secret,
				'origin' => $this->origin
			];
		}

		public function connect()
		{
			if( !$this->client )
			{
					$this->client = Convertkit_Client::factory( $this->prepareCredentials() );
			}

			return $this->client;
		}
	}

$x = new Test();
$client = $x->connect();
$zmienna = $client->getAllLists( [], false );


var_dump($zmienna);
