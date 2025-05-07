<?php

namespace App\Enums;

enum Action: string
{
    case All = '*';
    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
    case Restore = 'restore';
    case ForceDelete = 'forceDelete';
}
