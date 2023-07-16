<?php

namespace Tschucki\Pr0grammApi\Enums;

enum Vote: int
{
    case UP = 1;
    case DOWN = -1;
    case NEUTRAL = 0;
    case FAVORITE = 2;
}
