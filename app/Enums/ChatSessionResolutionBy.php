<?php

namespace App\Enums;

enum ChatSessionResolutionBy: string
{
    case ASSISTANT = 'assistant'; //For AI
    case SUPPORT = 'support'; //Human Admin
}
