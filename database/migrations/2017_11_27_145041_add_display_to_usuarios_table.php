<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayToUsuariosTable extends Migration {

    public function up() {
        Schema::table('Usuarios', function (Blueprint $table) {
            $table->string('display')->nullable()->after('email');
        });
    }

    public function down() {
        Schema::table('Usuarios', function (Blueprint $table) {
            $table->dropColumn('display');
        });
    }
}
