<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status_id' => "required",
            'user_name' => "required|unique:users,user_name",
            'name' => "required",
            'email' => "required|email|unique:users,email",
            'department_id' => "required",
            'password' => "required|confirmed",
            'file'  => 'nullable'
        ];
    }
    public function messages()
    {
        return [
            'status_id.required' => 'Bạn chưa chọn trạng thái',
            'user_name.required' => 'Bạn chưa nhập tên tài khoản ',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'department_id.required' => 'Bạn chưa nhập phòng ban ',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.confirmed' => 'Mật khẩu không trùng khớp',

        ];
    }
}
