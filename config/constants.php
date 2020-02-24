<?php

return [
    'status' => [
        'new' => 0,
        'pending' => 1,
        'waitForPic' => 2,
        'onGoing' => 3,
        'completed' => 4,
        'rejected' => -1,
        // etc
    ],
    'statusReverse' => [
        0 => 'new',
        1 => 'pending',
        2 => 'waitForPic',
        3 => 'onGoing',
        4 => 'completed',
        -1 => 'rejected',
        // etc
    ]

];
