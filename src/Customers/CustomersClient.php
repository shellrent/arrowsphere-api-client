<?php

namespace ArrowSphere\PublicApiClient\Customers;

use ArrowSphere\PublicApiClient\AbstractClient;
use ArrowSphere\PublicApiClient\Customers\Entities\Agreements;
use ArrowSphere\PublicApiClient\Customers\Entities\Credentials;
use ArrowSphere\PublicApiClient\Customers\Entities\Customer;
use ArrowSphere\PublicApiClient\Exception\EntityValidationException;
use ArrowSphere\PublicApiClient\Exception\NotFoundException;
use ArrowSphere\PublicApiClient\Exception\PublicApiClientException;
use Generator;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class CustomersClient
 */
class CustomersClient extends AbstractClient
{
    /**
     * @param array $parameters Optional parameters to add to the URL
     *
     * @return string
     *
     * @throws PublicApiClientException
     * @throws NotFoundException
     * @throws GuzzleException
     */
    public function getCustomersRaw(array $parameters = []): string
    {
        $this->path = '/customers';

        return $this->get($parameters);
    }

    /**
     * Lists the customers.
     * Returns an array (generator) of Customer.
     *
     * @param array $parameters Optional parameters to add to the URL
     *
     * @return Generator|Customer[]
     *
     * @throws EntityValidationException
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws PublicApiClientException
     */
    public function getCustomers(array $parameters = []): Generator
    {
        $this->setPerPage(100);
        $currentPage = 1;
        $lastPage = false;

        while (! $lastPage) {
            $this->setPage($currentPage);
            $rawResponse = $this->getCustomersRaw($parameters);
            $response = $this->decodeResponse($rawResponse);

            if ($response['pagination']['total_page'] <= $currentPage) {
                $lastPage = true;
            }

            $currentPage++;

            foreach ($response['data']['customers'] as $data) {
                yield new Customer($data);
            }
        }
    }

    /**
     * Creates a customer and returns its newly created reference.
     *
     * @param array $parameters Optional parameters to add to the URL
     * @param Customer $customer
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws PublicApiClientException
     * @throws GuzzleException
     */
    public function createCustomer(Customer $customer, array $parameters = []): string
    {
        $payload = $customer->jsonSerialize();
        unset(
            $payload[Customer::COLUMN_DELETED_AT],
            $payload[Customer::COLUMN_REFERENCE]
        );

        $this->path = '/customers';

        $rawResponse = $this->post($payload, $parameters);

        $response = $this->decodeResponse($rawResponse);

        return $response['data']['reference'];
    }
	
	/**
	 * @param string $customerReference
	 *
	 * @throws EntityValidationException
	 * @throws GuzzleException
	 * @throws NotFoundException
	 * @throws PublicApiClientException
	 *
	 * @return Customer
	 */
	public function getCustomerDetails( string $customerReference ): Customer {
		$this->path = '/customers/' . $customerReference;
		
		$rawResponse = $this->get();
		$response = $this->decodeResponse( $rawResponse );
		
		$customers =  $response['data']['customers'];
		
		return new Customer( array_shift( $customers ) );
    }
	
	/**
	 * @param string $customerReference
	 * @param string $vendor
	 */
	public function getCustomerCredentials( string $customerReference, string $vendor ): Credentials {
		$this->path = sprintf( '/customers/%s/vendor/%s/credentials', $customerReference, $vendor );
		
		$rawResponse = $this->get();
		$response = $this->decodeResponse( $rawResponse );
		
		return new Credentials( $response['data'] );
    }
	
	/**
	 * @param string $customerReference
	 * @param Agreements $agreements
	 *
	 * @throws GuzzleException
	 * @throws NotFoundException
	 * @throws PublicApiClientException
	 */
	public function createCustmerAgreements( string $customerReference, Agreements $agreements ) {
		$this->path = sprintf( '/customers/%s/agreements', $customerReference );
		
		$this->post( $agreements->jsonSerialize() );
    }
	
	/**
	 * @param string $customerReference
	 * @param string $vendor
	 *
	 * @throws GuzzleException
	 * @throws NotFoundException
	 * @throws PublicApiClientException
	 */
	public function getCustomerAgreements( string $customerReference, string $vendor ) {
		$this->path = sprintf( '/customers/%s/agreements', $customerReference );
		
		$rawResponse = $this->get( [
			'vendor' => $vendor
		]);
		$response = $this->decodeResponse( $rawResponse );
		
		$agreements = [];
		foreach( $response['data']['agreements'] as $agreementsRow ) {
			$agreements[] = new Agreements($agreementsRow);
		}
		
		return $agreements;
    }
}
