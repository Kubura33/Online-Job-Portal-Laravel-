<?php
namespace App\Enums;
enum ApplicationStatus : int {
    case UNANSWERED = -1;
    case DENIED = 1;
    CASE ACCEPTED = 0;
}
