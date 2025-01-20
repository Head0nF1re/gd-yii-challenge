<?php

namespace app\constants;

enum UserStatus: int
{
    case PendingEmailConfirmation = 1;
    case Active = 2;
    case Locked = 3;
    case Banned = 4;
}
