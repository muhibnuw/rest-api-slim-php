<?php

namespace Tests\Functional;

class UsersTest extends BaseTestCase
{
    private static $id;

    /**
     * Test Get All Users.
     */
    public function testGetUsers()
    {
        $response = $this->runApp('GET', '/users');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('Juan', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Get One User.
     */
    public function testGetUser()
    {
        $response = $this->runApp('GET', '/users/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('Juan', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Get User Not Found.
     */
    public function testGetUserNotFound()
    {
        $response = $this->runApp('GET', '/users/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotContains('id', $result);
        $this->assertNotContains('name', $result);
        $this->assertContains('error', $result);
    }

    /**
     * Test Search Users.
     */
    public function testSearchUsers()
    {
        $response = $this->runApp('GET', '/users/search/j');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('Juan', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Search User Not Found.
     */
    public function testSearchUserNotFound()
    {
        $response = $this->runApp('GET', '/users/search/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotContains('id', $result);
        $this->assertNotContains('name', $result);
        $this->assertContains('error', $result);
    }

    /**
     * Test Create User.
     */
    public function testCreateUser()
    {
        $response = $this->runApp('POST', '/users', array('name' => 'Esteban'));

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->message->id;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('Esteban', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Create User Without Name.
     */
    public function testCreateUserWithoutName()
    {
        $response = $this->runApp('POST', '/users');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertNotContains('id', $result);
        $this->assertNotContains('name', $result);
        $this->assertContains('error', $result);
    }

    /**
     * Test Update User.
     */
    public function testUpdateUser()
    {
        $response = $this->runApp(
            'PUT', '/users/' . self::$id, array('name' => 'Victor')
        );

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('Victor', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Update User Without Send Data.
     */
    public function testUpdateUserWithOutData()
    {
        $response = $this->runApp('PUT', '/users/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertNotContains('id', $result);
        $this->assertNotContains('name', $result);
        $this->assertContains('error', $result);
    }

    /**
     * Test Update User Not Found.
     */
    public function testUpdateUserNotFound()
    {
        $response = $this->runApp(
            'PUT', '/users/123456789', array('name' => 'Victor')
        );

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotContains('id', $result);
        $this->assertNotContains('name', $result);
        $this->assertContains('error', $result);
    }

    /**
     * Test Delete User.
     */
    public function testDeleteUser()
    {
        $response = $this->runApp('DELETE', '/users/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('success', $result);
        $this->assertNotContains('error', $result);
    }

    /**
     * Test Delete User Not Found.
     */
    public function testDeleteUserNotFound()
    {
        $response = $this->runApp('DELETE', '/users/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotContains('success', $result);
        $this->assertContains('error', $result);
    }
}
