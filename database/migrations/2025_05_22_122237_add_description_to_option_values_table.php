<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('option_values', function (Blueprint $table) {
        $table->text('description')->nullable()->after('additional_price');
    });
}

public function down()
{
    Schema::table('option_values', function (Blueprint $table) {
        $table->dropColumn('description');
    });
}

};
