<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resignations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('reason');
            $table->string('other_reason')->nullable();
            $table->text('comment_on_resignation');
            $table->date('date_of_resignation');
            $table->date('date_of_leaving');
            $table->date('date_of_withdraw')->nullable();
            $table->text('comment_on_withdraw')->nullable();
            $table->date('changed_dol')->nullable();
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
        Schema::dropIfExists('resignations');
    }
}
