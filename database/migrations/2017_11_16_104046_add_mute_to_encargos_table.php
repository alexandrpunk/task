<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMuteToEncargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Encargos', function (Blueprint $table) {
            $table->boolean('mute')->after('ultima_notificacion')->default(0);
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
            $table->dropColumn('mute');
        });
    }
}
