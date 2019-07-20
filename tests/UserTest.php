<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 20-Jul-19
 * Time: 17:20
 */


use Laravel\Lumen\Testing\DatabaseMigrations;
use \App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanIReadAllUsers()
    {

        $response = $this->get('/users');
        return $response->seeJsonStructure([
            'current_page',
            'data'
        ]);

    }

    public function testCanIPostSomeUser()
    {
        $user = factory('App\User')->make(['password' => 'eaemen']);
        $data = $user->toArray();
        $data['password'] = \Illuminate\Support\Facades\Hash::make('fodase');

        $response = $this->post('/users', $data);
        $response->seeJsonStructure(['id']);
    }

    public function testCanIRetrieveASpeficicUser()
    {
        $user = factory('App\User')->make(['password' => 'eaemen']);
        $data = $user->toArray();
        $data['password'] = \Illuminate\Support\Facades\Hash::make('fodase');

        $response = $this->post('/users', $data);
        $response->seeJsonStructure(['id']);
        $generatedUser = $response->response->getOriginalContent();

        $response = $this->get('/users/' . $generatedUser->id);
        $response->seeJsonStructure(['id', 'name', 'age', 'email']);
    }

    public function testCanIUpdateASpecificUser()
    {
        $user = factory('App\User')->make(['password' => 'eaemen']);
        $data = $user->toArray();
        $data['password'] = \Illuminate\Support\Facades\Hash::make('fodase');

        $response = $this->post('/users', $data);
        $response->seeJsonStructure(['id']);
        $generatedUser = $response->response->getOriginalContent();

        $data = [
            'name' => 'Daniel Reis',
            'age' => 20,
            'email' => 'idanielreiss@gmail.com'
        ];

        $response = $this->put('/users/' . $generatedUser->id, $data);

        return $response->seeInDatabase('users', $data);
    }

    public function testCanIDeleteASpecificUser()
    {
        $user = factory('App\User')->make(['email' => 'idanielreiss@gmail.com']);
        $data = $user->toArray();
        $data['password'] = \Illuminate\Support\Facades\Hash::make('fodase');

        $response = $this->post('/users', $data);
        $response->seeJsonStructure(['id']);
        $generatedUser = $response->response->getOriginalContent();

        $response = $this->delete('/users/' . $generatedUser->id);
        $response->assertResponseOk();

        $this->notSeeInDatabase('users', ['id' => $generatedUser->id]);
    }

    public function testCheckIfIsEmailDuplicating()
    {
        $user = factory('App\User')->make(['email' => 'idanielreiss@gmail.com']);
        $data = $user->toArray();
        $data['password'] = \Illuminate\Support\Facades\Hash::make('fodase');

        $response = $this->post('/users', $data);
        $response->seeJsonStructure(['id']);

        $response = $this->post('/users',$data);
        $response->seeStatusCode(422);
    }


}
