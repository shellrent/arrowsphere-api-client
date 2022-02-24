<?php

namespace ArrowSphere\PublicApiClient\Customers\Entities;

use ArrowSphere\PublicApiClient\AbstractEntity;
use ArrowSphere\PublicApiClient\Exception\EntityValidationException;
use Phalcon\Factory\AbstractFactory;

class Credentials extends AbstractEntity {
	
	const COLUMN_USERNAME = 'username';
	const COLUMN_PASSWORD = 'password';
	const COLUMN_URL = 'url';
	const COLUMN_VENDOR = 'vendor';
	
	protected const VALIDATION_RULES = [
		self::COLUMN_USERNAME      => 'required',
		self::COLUMN_PASSWORD => 'required',
		self::COLUMN_URL  => 'required',
		self::COLUMN_VENDOR      => 'required',
	];
	
	/**
	 * @var string
	 */
	private $username;
	
	/**
	 * @var string
	 */
	private $password;
	
	/**
	 * @var string
	 */
	private $url;
	
	/**
	 * @var string
	 */
	private $vendor;
	
	/**
	 * Credentials constructor.
	 *
	 * @param array $data
	 *
	 * @throws EntityValidationException
	 */
	public function __construct( array $data ) {
		parent::__construct( $data );
		
		$this->username = $data[self::COLUMN_USERNAME];
		$this->password = $data[self::COLUMN_PASSWORD];
		$this->url = $data[self::COLUMN_URL];
		$this->vendor = $data[self::COLUMN_VENDOR];
	}
	
	/**
	 * @return array
	 */
	public function jsonSerialize() {
		return [
			self::COLUMN_USERNAME => $this->username,
			self::COLUMN_PASSWORD => $this->password,
			self::COLUMN_URL => $this->url,
			self::COLUMN_VENDOR => $this->vendor,
		];
	}
	
	/**
	 * @return string
	 */
	public function getUsername(): string {
		return $this->username;
	}
	
	/**
	 * @return string
	 */
	public function getPassword(): string {
		return $this->password;
	}
	
	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}
	
	/**
	 * @return string
	 */
	public function getVendor(): string {
		return $this->vendor;
	}
}