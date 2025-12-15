<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('producto')) {
            // If the table doesn't exist, do nothing - this migration expects the existing schema.
            return;
        }

        if (!Schema::hasColumn('producto', 'imagen')) {
            Schema::table('producto', function (Blueprint $table) {
                $table->string('imagen', 255)->nullable()->after('descripcion');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('producto') && Schema::hasColumn('producto', 'imagen')) {
            Schema::table('producto', function (Blueprint $table) {
                $table->dropColumn('imagen');
            });
        }
    }
};
