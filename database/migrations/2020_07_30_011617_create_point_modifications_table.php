<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_modifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->decimal('points', 8, 2);
            $table->text('notes')->nullable();
            $table->boolean('add')->default(0)->comment('add (true) or deduct (false) action');
            $table->boolean('processed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_modifications');
    }
}
