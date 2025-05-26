<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('footer_infos', function (Blueprint $table) {
            $table->text('about_ar')->nullable();
            $table->text('working_hours_ar')->nullable();
            $table->string('copyright_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_info', function (Blueprint $table) {
            //
        });
    }
};
