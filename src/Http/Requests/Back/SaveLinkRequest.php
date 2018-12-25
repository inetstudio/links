<?php

namespace InetStudio\Links\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Links\Contracts\Http\Requests\Back\SaveLinkRequestContract;

/**
 * Class SaveLinkRequest.
 */
class SaveLinkRequest extends FormRequest implements SaveLinkRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            /*
            'type.required' => 'Поле «Тип ссылки» обязательно для заполнения',
            'type.string' => 'Поле «Тип ссылки» должно содержать текстовое значение',

            'linkable_type.required_unless' => 'Не определена модель материала',
            'linkable_type.string' => 'Значение модели материала должно быть текстовым',
            'linkable_type.max' => 'Значение модели материала не должно превышать 255 символов',

            'linkable_id.required' => 'Значение id модели материала обязательно для заполнения',
            'linkable_id.integer' => 'Значение id модели материала должно быть числовым',

            'additional_info.title.required' => 'Поле «Заголовок» обязательно для заполнения',

            'additional_info.path.required' => 'Поле «Ссылка» обязательно для заполнения',
            */
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            /*
            'type' => 'required|string',
            'linkable_type' => 'required_unless:linkable_id,0|string|max:255',
            'linkable_id' => 'required|integer',
            'additional_info.title' => 'required',
            'additional_info.path' => 'required',
            */
        ];
    }
}
