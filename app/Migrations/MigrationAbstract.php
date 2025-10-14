<?php

namespace App\Migrations;

use Illuminate\Database\Migrations\Migration as BaseMigration;

abstract class MigrationAbstract extends BaseMigration {
    public $withinTransaction = false;
}
