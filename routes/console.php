<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('notify:doc-expiry')->daily();

// Shared hosting queue worker simulation
Schedule::command('queue:work --stop-when-empty')->everyMinute();
