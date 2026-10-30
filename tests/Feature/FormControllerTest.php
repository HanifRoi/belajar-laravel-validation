<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    public function testLoginFailed()
    {
        $response = $this->post('form/login', [
            'username'=>'',
            'password'=>''
        ]);
        $response->assertStatus(400);
    }

    public function testLoginSuccess()
    {
        $response = $this->post('form/login', [
            'username'=>'Hanif',
            'password'=>'123456'
        ]);
        $response->assertStatus(200);
    }

    public function testFormSubmitSuccess()
    {
        $response = $this->post('form', [
            'username'=>'Hanif',
            'password'=>'123456'
        ]);
        $response->assertStatus(200);
    }

    public function testFormSubmitFailde()
    {
        $response = $this->post('form', [
            'username'=>'',
            'password'=>''
        ]);
        $response->assertStatus(302);
    }
}
