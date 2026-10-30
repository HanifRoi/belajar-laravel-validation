<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class ValidatorTest extends TestCase
{
    public function testValidator()
    {
        $data = [
            'username'=>'admin',
            'password'=>'admin123'
        ];

        $rules = [
            'username'=>'required',
            'password'=>'required'
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        assertTrue($validator->passes());
        assertFalse($validator->fails());

    }

    public function testValidatorInvalid()
    {
        $data = [
            'username'=>'',
            'password'=>''
        ];

        $rules = [
            'username'=>'required',
            'password'=>'required'
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        assertFalse($validator->passes());
        assertTrue($validator->fails());

    }

    public function testValidatorInvalidGetMessage()
    {
        $data = [
            'username'=>'',
            'password'=>''
        ];

        $rules = [
            'username'=>'required',
            'password'=>'required'
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        assertFalse($validator->passes());
        assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));

    }

    public function testValidationExeption()
    {
        $data = [
            'username'=>'',
            'password'=>''
        ];

        $rules = [
            'username'=>'required',
            'password'=>'required'
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        try {
            $validator->validate();
            self::fail('ValidationException not thrown');
        } catch (ValidationException $exception) {
            assertNotNull($exception->validator);
            // $exception->errors(); bisa juga untuk menangkap pesan error
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorMultipleRules()
    {
        $data = [
            'username'=>'helo',
            'password'=>'helo'
        ];

        $rules = [
            'username'=>'required|max:100|email',//bisa kaya gini
            'password'=>['required', 'min:6', 'max:20']//atau bisa kaya gini
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        assertFalse($validator->passes());
        assertTrue($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));

    }

    public function testValidatorValidData()
    {
        $data = [
            'username'=>'hanif@gmail.com',
            'password'=>'rahasia',
            'admin'=>true //artinya si admin ini gak di masukan karena tidak divalidasi, gak akan kita ambil, lebih aman
        ];

        $rules = [
            'username'=>'required|max:100|email',//bisa kaya gini
            'password'=>['required', 'min:6', 'max:20']//atau bisa kaya gini
        ];
        
        $validator = Validator::make($data, $rules);
        assertNotNull($validator);

        try {
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            assertNotNull($exception->validator);
            // $exception->errors(); bisa juga untuk menangkap pesan error
            $message = $exception->validator->errors();
            Log::error($message->toJson(JSON_PRETTY_PRINT));
        }
    }
 

}
