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
            $table->string('comment')->nullable();
            $table->date('changed_dol')->nullable();
            $table->string('comment_dol_lead')->nullable();
            $table->string('comment_dol_head')->nullable();
            $table->string('comment_dol_hr')->nullable();
            $table->string('comment_lead')->nullable();
            $table->string('comment_head')->nullable();
            $table->string('comment_hr')->nullable();
            $table->string('comment_dow_lead')->nullable();
            $table->string('comment_dow_head')->nullable();
            $table->string('comment_dow_hr')->nullable();
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
