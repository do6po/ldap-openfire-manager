<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 2:27
 */

namespace App\Http\Requests;

use App\Models\LDAP\LDAP;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RosterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],
            'roster_path' => [
                'required',
                'string',
                'max:255',
            ],
            'users_group' => [
                'nullable',
                'string',
                'max:255',
            ],
            'ldap_id' => [
                'required',
                'integer',
                Rule::exists(LDAP::TABLE_NAME,'id'),
            ],
            'description' => 'max:1024',
        ];
    }
}