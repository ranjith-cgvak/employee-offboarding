<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->foreign('resignation_id')->references('id')->on('resignations');
            $table->string('skill_set_primary')->nullable();
            $table->string('skill_set_secondary')->nullable();
            $table->string('last_worked_project')->nullable();
            $table->string('attendance_rating')->nullable();
            $table->string('responsiveness_rating')->nullable();
            $table->string('responsibility_rating')->nullable();
            $table->string('commitment_on_task_delivery_rating')->nullable();
            $table->string('technical_knowledge_rating')->nullable();
            $table->string('logical_ability_rating')->nullable();
            $table->string('attitude_rating')->nullable();
            $table->string('overall_rating')->nullable();
            $table->text('lead_comment')->nullable();
            $table->text('head_comment')->nullable();
            $table->date('feedback_date')->nullable();
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
        Schema::dropIfExists('feedback');
    }
}
