<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->boolean('is_active')->default(true); // Agregar la columna is_active
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropColumn('is_active'); // Eliminar la columna si se hace rollback
        });
    }
}
