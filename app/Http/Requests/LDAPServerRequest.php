<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.08.18
 * Time: 15:10
 */

namespace App\Http\Requests;

use App\Rules\Hostname;
use Illuminate\Foundation\Http\FormRequest;

class LDAPServerRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:servers|max:255',
            'hostname' => [
                'required',
                'string',
                'unique:servers',
                new Hostname(),
            ],
            'port' => 'nullable|integer|digits_between:1,65535',
            'username' => 'required|string|max:64',
            'password' => 'required|string|max:64',
            'description' => 'max:1024',
        ];
    }
}