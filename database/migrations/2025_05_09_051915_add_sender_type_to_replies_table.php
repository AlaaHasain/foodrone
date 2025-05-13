<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('replies', function (Blueprint $table) {
            $table->string('sender_type')->default('admin'); // admin or customer
        });
    }
    
    public function down()
    {
        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn('sender_type');
        });
    }
};
