<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\GameType;
use App\Models\Game;

class CreateGameRequest extends FormRequest
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
        return [
            'type' => ['required', 'in:' . GameType::getValuesString()],
            'players_number' => ['required', 'numeric', 'min:1', 'max:4'],
            'users' => ['required', 'array', 'size:' . $this->players_number],
            'users.*' => ['required', 'exists:users,name', 'distinct']
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'ゲームタイプ',
            'players_number' => 'プレイヤー人数',
            'users' => 'ユーザ名',
            'users.0' => 'ユーザ名(1人目)',
            'users.1' => 'ユーザ名(2人目)',
            'users.2' => 'ユーザ名(3人目)',
            'users.3' => 'ユーザ名(4人目)'
        ];
    }
}
