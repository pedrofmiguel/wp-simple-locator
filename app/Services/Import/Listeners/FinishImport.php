<?php namespace SimpleLocator\Services\Import\Listeners;

class FinishImport {

	/**
	* Transient
	*/
	private $transient;

	public function __construct()
	{
		$this->getTransient();
		$this->response();
	}

	/**
	* Get the Transient
	*/
	private function getTransient()
	{
		$this->transient = get_transient('wpsl_import_file');
		$this->transient['complete'] = true;
		set_transient('wpsl_import_file', $this->transient, 1 * YEAR_IN_SECONDS);
	}

	/**
	* Send the Response
	*/
	private function response()
	{
		return wp_send_json(array(
			'status' => 'success', 
			'import_count' => $this->transient['complete_rows'], 
			'error_count'=> count($this->transient['error_rows']), 
			'errors' => $this->transient['error_rows']
		));
	}

}