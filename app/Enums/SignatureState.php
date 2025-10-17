<?php

namespace App\Enums;

enum SignatureState: string
{
    case DONE = "تم";
    case WAIT = "في الانتظار";
}
