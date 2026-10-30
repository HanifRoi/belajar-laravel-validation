<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = [
            'username'=>'admin',
            'password'=>'admin123'
        ];

        $rules = [
            'admin'=>'required',
            'password'=>'required'
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);
    }
}
