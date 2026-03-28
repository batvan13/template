<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'message'    => ['required', 'string', 'min:10', 'max:2000'],
            'company'    => ['nullable', 'string', 'max:0'],
            'opened_at'  => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Моля, въведете вашето име.',
            'name.max'            => 'Името не може да надвишава 100 символа.',
            'email.required'      => 'Моля, въведете имейл адрес.',
            'email.email'         => 'Имейл адресът не е валиден.',
            'email.max'           => 'Имейл адресът е прекалено дълъг.',
            'phone.max'           => 'Телефонният номер не може да надвишава 30 символа.',
            'message.required'    => 'Моля, въведете съобщение.',
            'message.min'         => 'Съобщението трябва да съдържа поне 10 символа.',
            'message.max'         => 'Съобщението не може да надвишава 2000 символа.',
            'company.max'         => 'Моля, проверете данните и опитайте отново.',
            'opened_at.required'  => 'Моля, проверете данните и опитайте отново.',
            'opened_at.integer'   => 'Моля, проверете данните и опитайте отново.',
            'opened_at.min'       => 'Моля, проверете данните и опитайте отново.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            if ($v->errors()->isNotEmpty()) {
                return;
            }

            $opened = (int) $this->input('opened_at', 0);

            if ($opened > 0 && (time() - $opened) < 2) {
                $v->errors()->add('inquiry', 'Моля, изчакайте момент и опитайте отново.');
            }
        });
    }
}
