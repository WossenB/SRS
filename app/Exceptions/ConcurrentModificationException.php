<?php

namespace App\Exceptions;

use Exception;

class ConcurrentModificationException extends Exception
{
    protected $message = 'The record has been modified by another user. Please refresh and try again.';
}
