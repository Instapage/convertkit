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
			return isset( $this->data[ 'result' ] ) ? $this->data[ 'result' ] : null;
		}

		public function getError()
		{
			if ( isset( $this->data[ 'errors' ] ) && count( $this->data[ 'errors' ] ) )
			{
				return $this->data[ 'errors' ][ 0 ];
			}

			return null;
		}

		public function getWarning()
		{
			if( isset( $this->data[ 'warnings' ] ) && count( $this->data[ 'warnings' ] ) )
			{
				return $this->data[ 'warnings' ][ 0 ];
			}

			return null;
		}

		public static function fromCommand( OperationCommand $command )
		{
			return new static( $command->getResponse()->json() );
		}
	}
