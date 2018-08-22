<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.08.18
 * Time: 15:10
 */

namespace App\Http\Requests;


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
            'hostname' => 'required|unique:servers|alpha_dash|max:64',
            'port' => 'integer|digits_between:1,65500',
            'description' => 'max:1024',
        ];
    }
}