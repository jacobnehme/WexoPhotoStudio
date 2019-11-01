<?php

namespace Tests\Unit;



use Tests\TestCase;


use App\User;

class UserLoginTest extends TestCase
{

    public function testUserLoginView()
    {
        //Get login controller
        $result = $this->get('/login');

        //Assert that the result has a successful status code
        $result->assertSuccessful();

        //Assert that the result is Login view in auth folder
        $result->assertViewIs('auth.login');
    }

    public function testUserCantViewLoginView()
    {
        // NonPersisten user
        $user = factory(User::class)->make();

        // Set the currently logged in user for the application into a variable
        $result = $this->actingAs($user)->get('/login');

        // Assert user was redirected to the homepage
        $result->assertRedirect('/home');
    }

    public function testUserCanLogin()
    {
        //        TODO  Make statements for deleting user if test is failed
        // Make a persitent user
        $user      = User::Create([
            "name" => "Test2",
            "email" => "test@testing.dk",
            // Hash the given value against the bcrypt algorithm.
            "password" => bcrypt($password = '1234'),
            "role_id" => 1
        ]);

        // Send a post request to the login controller with credentials
        $result = $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        // Check if loggined you should redirect to home controller.
        $result->assertRedirect('/home');

        // Assert that the user is authenticated as the given user
        $this->assertAuthenticatedAs($user);

        // Delete test user from db
        $user->delete();
    }

    public function testUserCantLogin()
    {
//        TODO  Make statements for deleting user if test is failed
        // Make a persitent user
        $user      = User::Create([
            "name" => "Test2",
            "email" => "test@testing.dk",
            // Hash the given value against the bcrypt algorithm.
            "password" => bcrypt($password = '1234'),
            "role_id" => 1
        ]);

        // Send a post request to the login controller with credentials
        // FromHelper make sure user is redirected back to the login page else it would be redirected to /
        $result = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'bad password'
        ]);

        // Redirect to login again
        $result->assertRedirect('/login');

        // Assert that the session has the given errors
        $result->assertSessionHasErrors('email');

        // Determine if the session contains old input.
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));

        // Delete test user from db
        $user->delete();
    }

}
