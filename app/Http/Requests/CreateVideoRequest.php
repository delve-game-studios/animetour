<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mimeTypes = ['video/mp4', 'video/3gpp', 'video/3gpp2', 'video/webm', 'video/ogg', 'video/mpeg', 'video/x-msvideo'];

        return [
            'entry_type' => 'required',
            'entry_file.*' => 'required_if:entry_type,File|file|mimetypes:' . implode(',', $mimeTypes),
            'entry_url' => 'required_if:entry_type,URL'
        ];
    }
}
