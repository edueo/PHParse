<?php 
class ParseObjectTest extends PHPUnit_Framework_TestCase
{

	public function testIfKeysIsLoaded()
	{
		$parseObject = new PHParse\ParseObject;

		$this->assertEquals(40, strlen($parseObject->appId()));
		$this->assertEquals(40, strlen($parseObject->restApiKey()));
		$this->assertEquals(40, strlen($parseObject->masterKey()));
	}

	public function testCreate()
	{
		$parseObject = new PHParse\ParseObject;
		$objectId = $parseObject->create('Test', array('value1' => 'foo', 'value2' => 'baz', 'amount' => 0));

			
		$this->assertNotNull($objectId);
		return $objectId;
		

	}

	/**
     * @depends testCreate
     */
	public function testRetrieveByObjectId($objectId)
	{
		
		$parseObject = new PHParse\ParseObject;
		$result = $parseObject->retrieveByObjectId('Test', $objectId);

		$this->assertArrayHasKey('createdAt', $result);
		$this->assertArrayHasKey('updatedAt', $result);
		$this->assertArrayHasKey('objectId', $result);

		return $objectId;

	}
	/**
     * @depends testRetrieveByObjectId
     */
	public function testUpdateObject($objectId)
	{	
		$parseObject = new PHParse\ParseObject;
		$result = $parseObject->update('Test', $objectId, array('value2' => 'bar', 'value3' => 'zaz', "skills" => array("php", ".net", "js")));
		$this->assertArrayHasKey('updatedAt', $result);

	}

	/**
     * @depends testCreate
     */
	public function testIncrementField($objectId)
	{	
		$parseObject = new PHParse\ParseObject;
		$result = $parseObject->incrementField('Test', $objectId, 'amount');
		$this->assertArrayHasKey('updatedAt', $result);
		
	}
	/**
     * @depends testCreate
     */
	public function testDecrementField($objectId)
	{
		$parseObject = new PHParse\ParseObject;
		$result = $parseObject->decrementField('Test', $objectId, 'amount');
		$this->assertArrayHasKey('updatedAt', $result);

	}
	/**
     * @depends testCreate
     */
	/*public function testAddArrayData($objectId)
	{
		$parseObject = new PHParse\ParseObject;
		$result = $parseObject->addArrayData('Test', $objectId, array("skills" => array("python", "ruby")));
		$this->assertArrayHasKey('updatedAt', $result);				

	}*/
	

}