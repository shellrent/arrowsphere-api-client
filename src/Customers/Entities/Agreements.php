<?php

namespace ArrowSphere\PublicApiClient\Customers\Entities;

use ArrowSphere\PublicApiClient\AbstractEntity;

class Agreements extends AbstractEntity {
	const COLUMN_AGREEMENT_TYPE = 'agreement_type';
	const COLUMN_VENDOR = 'vendor';
	const COLUMN_CONTACT = 'contact';
	const COLUMN_SET_AS_PRIMARY = 'set_as_primary';
	const COLUMN_AGREEMENT_REFERENCE = 'agreement_reference';
	const COLUMN_AGREEMENT_DATE = 'agreement_date';
	const COLUMN_STATUS_CODE = 'status_code';
	const COLUMN_STATUS_LABEL = 'status_label';
	
	protected const VALIDATION_RULES = [
		self::COLUMN_VENDOR => 'required',
		self::COLUMN_CONTACT => 'required|array',
		self::COLUMN_AGREEMENT_TYPE => 'required',
	];
	
	/**
	 * @var string
	 */
	private $AgreementType;
	
	/**
	 * @var string
	 */
	private $Vendor;
	
	/**
	 * @var Contact
	 */
	private $Contact;
	
	/**
	 * @var bool
	 */
	private $SetAsPrimary;
	
	/**
	 * @var string
	 */
	private $AgreementReference;
	
	/**
	 * @var string
	 */
	private $AgreementDate;
	
	/**
	 * @var int
	 */
	private $StatusCode;
	
	/**
	 * @var string
	 */
	private $StatusLabel;
	
	public function __construct( array $data ) {
		parent::__construct( $data );
		
		$this->AgreementType = $data[self::COLUMN_AGREEMENT_TYPE];
		$this->Vendor = $data[self::COLUMN_VENDOR];
		$this->Contact = new Contact( $data[self::COLUMN_CONTACT] );
		$this->SetAsPrimary = $data[self::COLUMN_SET_AS_PRIMARY] ?? null;
		$this->AgreementReference = $data[self::COLUMN_AGREEMENT_REFERENCE] ?? null;
		$this->AgreementDate = $data[self::COLUMN_AGREEMENT_DATE] ?? null;
		$this->StatusCode = $data[self::COLUMN_STATUS_CODE] ?? null;
		$this->StatusLabel = $data[self::COLUMN_STATUS_LABEL] ?? null;
	}
	
	
	public function jsonSerialize() {
		$jsonStruct = [
			self::COLUMN_AGREEMENT_TYPE => $this->AgreementType,
			ucfirst( self::COLUMN_CONTACT ) => $this->Contact->jsonSerialize(),
			self::COLUMN_VENDOR => $this->Vendor,
		];
		
		if( !is_null( $this->SetAsPrimary ) ) {
			$jsonStruct[ self::COLUMN_SET_AS_PRIMARY ] = $this->SetAsPrimary;
		}
		
		return $jsonStruct;
	}
	
	/**
	 * @return string
	 */
	public function getAgreementType(): string {
		return $this->AgreementType;
	}
	
	/**
	 * @return string
	 */
	public function getVendor(): string {
		return $this->Vendor;
	}
	
	/**
	 * @return Contact
	 */
	public function getContact(): Contact {
		return $this->Contact;
	}
	
	/**
	 * @return bool
	 */
	public function isSetAsPrimary(): bool {
		return $this->SetAsPrimary;
	}
	
	/**
	 * @return string
	 */
	public function getAgreementReference(): string {
		return $this->AgreementReference;
	}
	
	/**
	 * @return string
	 */
	public function getAgreementDate(): string {
		return $this->AgreementDate;
	}
	
	/**
	 * @return int
	 */
	public function getStatusCode(): int {
		return $this->StatusCode;
	}
	
	/**
	 * @return string
	 */
	public function getStatusLabel(): string {
		return $this->StatusLabel;
	}
}