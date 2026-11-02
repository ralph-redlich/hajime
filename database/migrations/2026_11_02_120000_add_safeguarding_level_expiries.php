<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLES = ['personnels', 'coaches', 'volunteers'];

    public function up()
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->date('safeguarding_l1_expiry')->nullable();
                $table->date('safeguarding_l2_expiry')->nullable();
                $table->date('safeguarding_l3_expiry')->nullable();
            });
        }
    }

    public function down()
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['safeguarding_l1_expiry', 'safeguarding_l2_expiry', 'safeguarding_l3_expiry']);
            });
        }
    }
};
