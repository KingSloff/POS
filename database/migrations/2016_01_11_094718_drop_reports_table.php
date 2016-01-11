<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('reports');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description')->unique();
            $table->decimal('value');

            $table->timestamp('created_at')->useCurrent();

            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('reports')->insert([
            'description' => 'OpeningInventory',
            'value' => 0
        ]);
    }
}
