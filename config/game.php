<?php
use App\Enums\CommonCard;

return [
    'init' => [
        'hands_number' => [
            1 => 3,
            2 => 3,
            3 => 3,
            4 => 3,
        ],
        'money' => [
            1 => 5,
            2 => 6,
            3 => 7,
            4 => 8,
        ],
        'workers_number' => [
            1 => 2,
            2 => 2,
            3 => 2,
            4 => 2,
        ],
        'dolls_number' => [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
        ],
        'max_workers_number' => [
            1 => 5,
            2 => 5,
            3 => 5,
            4 => 5,
        ],
        'max_hand_cards_number' => [
            1 => 5,
            2 => 5,
            3 => 5,
            4 => 5,
        ],
    ],
    'wage' => [ 
        1 => 2,
        2 => 2,
        3 => 3,
        4 => 3,
        5 => 3,
        6 => 4,
        7 => 4,
        8 => 5,
        9 => 5,
    ],
    'new_public_building' => [
        2 => CommonCard::STALL,
        3 => CommonCard::MARKET,
        4 => CommonCard::HIGH_SCHOOL,
        5 => CommonCard::SUPER_MARKET,
        6 => CommonCard::UNIVERSITY,
        7 => CommonCard::DEPARTMENT_STORE,
        8 => CommonCard::COLLEGE,
        9 => CommonCard::EXPO,
    ],
];
