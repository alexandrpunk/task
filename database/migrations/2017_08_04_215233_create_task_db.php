<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('password')->nullable();
            $table->integer('status')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
        
         Schema::create('Relaciones_usuarios', function (Blueprint $table) {
             $table->integer('id_usuario1')->unsigned();
             $table->integer('id_usuario2')->unsigned();
             $table->integer('status')->unsigned();
             $table->timestamps();
             $table->primary(['id_usuario1', 'id_usuario2']);
        });
        
        Schema::create('Encargos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('encargo');
            $table->dateTime('fecha_plazo');	
            $table->dateTime('fecha_conclusion')->nullable();	
            $table->boolean('visto');
            $table->integer('id_asignador')->unsigned();
            $table->integer('id_responsable')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('Comentarios', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('comentario');
            $table->integer('id_usuario')->unsigned();
            $table->integer('id_encargo')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::table('Relaciones_usuarios', function (Blueprint $table) {
            $table->foreign('id_usuario1')->references('id')->on('Usuarios')->onDelete('cascade');
            $table->foreign('id_usuario2')->references('id')->on('Usuarios')->onDelete('cascade');
        });
        
        Schema::table('Comentarios', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id')->on('Usuarios')->onDelete('cascade');
            $table->foreign('id_encargo')->references('id')->on('Encargos')->onDelete('cascade');
        });
        
        Schema::table('Encargos', function (Blueprint $table) {
            $table->foreign('id_responsable')->references('id')->on('Usuarios')->onDelete('cascade');
            $table->foreign('id_asignador')->references('id')->on('Usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('Relaciones_usuarios');
        Schema::drop('Encargos');
        Schema::drop('Comentarios');
        Schema::drop('Usuarios');
    }
}
