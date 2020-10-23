<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Enums\CardType;
use App\Exceptions\GameInvalidActionException;

/**
 * 農村
 */
final class Building67 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\Discard;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::RURAL;
    private int $action_id;

    public function action(Request $request)
    {
        $this->action_id = $request->action_id;
        switch ($this->action_id) {
            case 1:
                $this->drawGoods(2);
                break;
            case 2:
                $hand_goods = $this->my_player->handCards->filter(fn($v) => $v->card->type === CardType::GOODS);
                if ($hand_goods->count() < 2)
                    throw new GameInvalidActionException('捨てる消費財が足りません');
                $discard_ids = $hand_goods->take(2)->pluck('id')->toArray();
                $this->discardGoods($discard_ids, 2);
                $this->drawPileCards(3);
                break;
            default:
                throw new GameInvalidActionException('不正な値です');
        }
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        $text = $this->my_player->user->name . 'は';
        switch ($this->action_id) {
            case 1:
                $text .= '消費財を2枚引いた';
                break;
            case 2:
                $text .= '消費財を2枚捨てて建物を3枚引いた';
                break;
            default:
                throw new GameInvalidActionException('不正な値です');
        }
        return $text;
    }
}
