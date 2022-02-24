<?php

namespace ArrowSphere\PublicApiClient\Order;

use ArrowSphere\PublicApiClient\AbstractClient;

class OrderClient extends AbstractClient {
	
	public function getOrderDetails( string $orderReference ) {
		$this->path = sprintf( '/orders/%s', $orderReference );
		
		$rawResponse = $this->get();
		$response = $this->decodeResponse( $rawResponse );
		
		return array_shift( $response['data']['orders'] );
	}
	
	
	public function createOrder( array $orderData ) {
		$this->path = 'orders';
		
		$rawResponse = $this->post( $orderData );
		
		$response = $this->decodeResponse($rawResponse);
		
		return $response['data']['reference'];
	}
}