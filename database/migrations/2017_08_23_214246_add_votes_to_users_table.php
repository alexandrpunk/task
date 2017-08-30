<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Encargos', function (Blueprint $table) {
             $table->dateTime('ultima_notificacion')->nullable()->default(null)->after('fecha_conclusion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Encargos', function (Blueprint $table) {
            $table->dropColumn('ultima_notificacion');
        });
    }
}
