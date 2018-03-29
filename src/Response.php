<?php

	namespace CSD\Convertkit;

	use Guzzle\Service\Command\OperationCommand;
	use Guzzle\Service\Command\ResponseClassInterface;

	class Response implements ResponseClassInterface
	{
		protected $data;

		public function __construct( $data )
		{
			$this->data = $data;
		}

		public function getResult()
		{
			return $this->data;
		}

		public static function fromCommand( OperationCommand $command )
		{
			return new static( $command->getResponse()->json() );
		}
	}
