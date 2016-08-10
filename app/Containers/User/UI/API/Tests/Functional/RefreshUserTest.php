<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Port\Tests\PHPUnit\Abstracts\TestCase;

/**
 * Class RefreshUserTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class RefreshUserTest extends TestCase
{

    private $endpoint = '/users/refresh';

    public function testRefreshUserById_()
    {
        // get the logged in user (create one if no one is logged in)
        $user = $this->registerAndLoginTestingUser();

        $data = [
            'user_id' => $user->id,
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data, false);

        // assert response status is correct
        $this->assertEquals($response->getStatusCode(), '200');
    }

    public function testRefreshUserByVisitorId_()
    {
        // get the logged in user (create one if no one is logged in)
        $user = $this->registerAndLoginTestingUser();
        unset($user->token);
        $user->visitor_id = str_random(40);
        $user->save();

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', [], false, ['visitor-id' => $user->visitor_id]);

        // assert response status is correct
        $this->assertEquals($response->getStatusCode(), '200');
    }

    public function testRefreshUserByToken_()
    {
        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', [], true);

        // assert response status is correct
        $this->assertEquals($response->getStatusCode(), '200');
    }
}
