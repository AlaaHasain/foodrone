<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->decimal('order_tax_rate', 5, 2)->default(8.00)->after('admin_email'); // القيمة الافتراضية 8%
    });
}

public function down()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn('order_tax_rate');
    });
}

};
