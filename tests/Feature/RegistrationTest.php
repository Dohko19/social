<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use function GuzzleHttp\Psr7\str;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {
        $this->get(route('register'))->assertSuccessful();
        $response = $this->post(route('register'), $this->userValidateData());

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'Daniel-Dohko19',
            'first_name' => 'Rojas',
            'last_name' => 'Uchiha',
            'email' => 'daniel@email.com',
        ]);

        $this->assertTrue(
            Hash::check('12345678', User::first()->password),
            'The password need to be hashed'
        );
    }

    /** @test */
    public function the_name_is_required()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['name' => null])
        )->assertSessionHasErrors('name');

    }


    /** @test **/
    function the_name_must_be_unique()
    {
        factory(User::class)->create(['name' => 'DanielTrejo']);
        $this->post(
            route('register'),
            $this->userValidateData([ 'name' => 'DanielTrejo' ])
        )->assertSessionHasErrors('name');
    }



    /** @test **/
    function the_name_only_contain_letters_and_numbers()
    {

        $this->post(
            route('register'),
            $this->userValidateData([ 'name' => 234 ])
        )->assertSessionHasErrors('name');
    }


    /** @test */
    public function the_name_must_be_a_string()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['name' => 1234])
        )->assertSessionHasErrors('name');

    }


    /** @test */
    public function the_name_must_be_a_greater_than_60_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'name' => Str::random(61) ])
        )->assertSessionHasErrors('name');

    }

    /** @test */
    public function the_first_name_is_required()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['first_name' => null])
        )->assertSessionHasErrors('first_name');

    }


    /** @test */
    public function the_first_name_must_be_a_string()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['first_name' => 1234])
        )->assertSessionHasErrors('first_name');

    }

    /** @test */
    public function the_first_name_must_be_a_greater_than_60_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'first_name' => Str::random(61) ])
        )->assertSessionHasErrors('first_name');

    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'name' => 'as' ])
        )->assertSessionHasErrors('name');

    }


    /** @test **/
    function the_first_name_only_contain_letters()
    {

        $this->post(
            route('register'),
            $this->userValidateData([ 'first_name' => 'DanielDohko19' ])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_last_name_is_required()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['last_name' => null])
        )->assertSessionHasErrors('last_name');

    }


    /** @test */
    public function the_last_name_must_be_a_string()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['last_name' => 1234])
        )->assertSessionHasErrors('last_name');

    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'first_name' => 'as' ])
        )->assertSessionHasErrors('first_name');

    }

    /** @test */
    public function the_last_name_must_be_a_greater_than_60_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'last_name' => Str::random(61) ])
        )->assertSessionHasErrors('last_name');

    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'last_name' => 'as' ])
        )->assertSessionHasErrors('last_name');

    }

    /** @test **/
    function the_last_name_only_contain_letters()
    {

        $this->post(
            route('register'),
            $this->userValidateData([ 'last_name' => 'DanielDohko19' ])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_email_is_required()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'email' => null ])
        )->assertSessionHasErrors('email');

    }

    /** @test **/
    function the_email_must_be_a_valid_email_address()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['email' => 'invalido@gmail'])
        )->assertSessionHasErrors('email');
    }

    /** @test **/
    function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'daniel@gmail.com']);
        $this->post(
            route('register'),
            $this->userValidateData([ 'email' => 'daniel@gmail.com' ])
        )->assertSessionHasErrors('email');
    }



    /** @test */
    public function the_password_is_required()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'password' => null ])
        )->assertSessionHasErrors('password');

    }




    /** @test */
    public function the_password_must_be_a_string()
    {

        $this->post(
            route('register'),
            $this->userValidateData(['password' => 1234])
        )->assertSessionHasErrors('password');

    }

    /** @test */
    public function the_password_must_be_at_least_6_characters()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([ 'password' => 'asdfg' ])
        )->assertSessionHasErrors('password');

    }


    /** @test */
    public function the_password_must_be_at_confirmed()
    {
//        $this->withoutExceptionHandling();
        $this->post(
            route('register'),
            $this->userValidateData([
                'password' => 'secret',
                'password_confirmation' => null
            ])
        )->assertSessionHasErrors('password');

    }

    /**
     * @param array $overrides
     * @return array
     */
    public function userValidateData($overrides = []): array
    {
        return array_merge([
            'name' => 'Daniel-Dohko19',
            'first_name' => 'Rojas',
            'last_name' => 'Uchiha',
            'email' => 'daniel@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ], $overrides);
    }
}
