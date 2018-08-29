<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.08.18
 * Time: 15:10
 */

namespace App\Http\Requests;

use App\Models\LDAP\LDAP;
use App\Rules\Hostname;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LDAPRequest extends FormRequest
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
        $id = $this->ldap->id ?? null;

        return [
            'name' => [
                'required',
                Rule::unique(LDAP::TABLE_NAME)->ignore($id),
                'max:255',
            ],
            'hostname' => [
                'required',
                'string',
                Rule::unique(LDAP::TABLE_NAME)->ignore($id),
                new Hostname(),
            ],
            'port' => 'integer|digits_between:1,65535',
            'username' => 'required|string|max:64',
            'password' => 'nullable|string|max:64',
            'description' => 'max:1024',
        ];
    }
}