<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use Illuminate\Support\Facades\DB;
use App\Models\GameHandCard;
use App\Models\GameLog;

/**
 * 醸造所
 */
final class Building56 extends BuildingBase implements Building
{
    public ?string $action_type = ActionType::RESERVE;

    public function reservedAction(int $player_id)
    {
        $reserved_player = $this->game->players->first(fn($p) => $p->id === $player_id);
        $goods_cards = [];
        for ($i = 0; $i < 4; $i++) {
            $goods_cards[] = [
                'game_id' => $this->game->id,
                'player_id' => $reserved_player->id,
                'card_id' => 1,
            ];
        }
        DB::table(GameHandCard::TABLE_NAME)->insert($goods_cards);
        $text = $reserved_player->user->name . 'は消費財を4枚引いた';
        GameLog::createReservedActionLog($this->game, $reserved_player, $this->building, $text);
    }

    public function canUse(): bool
    {
        if ($this->game->round >= 9) return false;
        return parent::canUse();
    }
}
