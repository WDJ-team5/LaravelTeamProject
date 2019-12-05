<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
{
	protected $dontFlash = ['file'];
	
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['array'],
			'file.*' => ['mimes: jpg, jpeg, png, zip, tar, bmp', 'max: 1000000'],
        ];
    }
}
