<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalExitChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_exit_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->foreign('resignation_id')->references('id')->on('resignations');
            $table->string('type_of_exit')->nullable();
            $table->date('date_of_leaving')->nullable();
            $table->string('reason_for_leaving')->nullable();
            $table->integer('last_drawn_salary')->nullable();
            $table->string('consider_for_rehire')->nullable();
            $table->string('overall_feedback')->nullable();
            $table->string('relieving_letter')->nullable();
            $table->string('experience_letter')->nullable();
            $table->string('salary_certificate')->nullable();
            $table->text('final_comment')->nullable();
            $table->string('documents')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('final_exit_checklists');
    }
}
