<?php namespace PHParse;

class ParseObject
{
	protected $appId;
	protected $restApiKey;
	protected $masterKey;
	protected $apiDomain = 'https://api.parse.com/{version}';
	protected $userAgent = 'PHParse';
	protected $client;

	public function __construct()
	{
		\Dotenv::load(__DIR__. '/..');

		$this->appId = getenv('PARSE_APP_ID');
		$this->restApiKey = getenv('PARSE_REST_API_KEY');
		$this->masterKey = getenv('PARSE_MASTER_KEY');

		$this->client = new \Guzzle\Http\Client($this->apiDomain, array(
			'version'         => '1',
			'request.options' => array(
				'headers'  => array(

					'X-Parse-Application-Id' => $this->appId,
					'X-Parse-REST-API-Key'   => $this->restApiKey,
					'Content-Type'           => 'application/json'
				),
				'timeout' => 60

			)
		));

		$this->client->setUserAgent($this->userAgent);
	}

	public function appId()
	{
		return $this->appId;
	}

	public function restApiKey()
	{
		return $this->restApiKey;
	}

	public function masterKey()
	{
		return $this->masterKey;
	}

	/**
	*
	* @TODO: Exception
	* @TODO: Return
	*/
	public function create($className, $content)
	{

		$request = $this->client->post('classes/'.$className, array(), json_encode($content));
		$response = $this->client->send($request);
		$result = $response->json(); 
		
	   return $response->getStatusCode() === 201 ? $result['objectId'] : null;

	}

	public function retrieveByObjectId($className, $objectId)
	{
		$request = $this->client->get('classes/'.$className. '/' . $objectId);
		$response = $this->client->send($request); 

		return $response->json();
	}

	public function update($className, $objectId, $content)
	{
		$request = $this->client->put('classes/'.$className. '/' . $objectId, array(), json_encode($content));
		$response = $this->client->send($request);
		return $response->json();
	}

	public function incrementField($className, $objectId, $field)
	{
		$content = array($field => array("__op" => "Increment", "amount" => 1) );
		$request = $this->client->put('classes/'.$className. '/' . $objectId, array(), json_encode($content));
		$response = $this->client->send($request);
		return $response->json();
	}

	public function decrementField($className, $objectId, $field)
	{
		$content = array($field => array("__op" => "Increment", "amount" => 1 * (-1)) );
		$request = $this->client->put('classes/'.$className. '/' . $objectId, array(), json_encode($content));
		$response = $this->client->send($request);
		return $response->json();	
	}

	/*public function addArrayData($className, $objectId, $arrayData)
	{
		$arrayField = array_keys($arrayData);
		$arrayValues = array_values($arrayData);
		
		$content = array($arrayField[0] => array("__op" => "AddUnique", "objects" => array("s", "sas")) );
		$request = $this->client->put('classes/'.$className. '/' . $objectId, array(), json_encode($content));
		$response = $this->client->send($request);
		return $response->json();		

	}*/

}