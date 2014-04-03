<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSetting extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tblSetting', function($table) {
            $table->increments('id');
            $table->string('settingKey');
            $table->string('settingValue');
            $table->string('time');
            $table->integer('status');
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
