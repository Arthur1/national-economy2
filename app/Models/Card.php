<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GameType;
use App\Enums\CardSeries;
use App\Enums\CommonCard;

class Card extends Model
{
    use HasFactory;

    public static function createDeck(Game $game): array
    {
        if ($game->type === GameType::MIX) {
            $cards = self::where('series', '!=', CardSeries::COMMON)->get();
        } else {
            $cards = self::where('series', '=', $game->type)->get();
        }
        $deck_cards = [];
        foreach ($cards as $card) {
            for ($i = 0; $i < $card->number; $i++) {
                $deck_cards[] = $card->id;
            }
        }
        shuffle($deck_cards);

        return $deck_cards;
    }
}
