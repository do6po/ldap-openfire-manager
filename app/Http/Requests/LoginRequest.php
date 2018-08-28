<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 27.08.2018
 * Time: 23:53
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|no_js_validation',
            'password' => 'required|string|no_js_validation',
        ];
    }
}