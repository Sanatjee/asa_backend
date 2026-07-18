<?php

namespace App\Enums;

enum ChatSessionResolution: string
{
    case RESOLVED = 'resolved';
    case UNRESOLVED = 'usresolved';
    case FOLLOWUP = 'followup';
}
