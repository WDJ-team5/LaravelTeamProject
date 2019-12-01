<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//인증로직
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function messages()
    {
        return [
           
        ];
    }

    public function attributes()
    {
        return [
            'email' => '이메일',
            'password' => '비밀번호',
            'password_confirmation' => '비밀번호 확인',
            'name' => '이름',
            'year' => '날짜',
            'month' => '날짜',
            'day' => '날짜',
            'gender' => '성별',
            'hint' => '힌트',
            'answer' => '정답'
        ];
    }

}
