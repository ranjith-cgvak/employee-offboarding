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
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')->references('id')->on('users');
            $table->unsignedBigInteger('commenter_id');
            $table->foreign('commenter_id')->references('id')->on('users');
            $table->string('skill_set_primary');
            $table->string('skill_set_secondary');
            $table->string('last_worked_project');
            $table->string('attendance_rating');
            $table->string('responsiveness_rating');
            $table->string('responsibility_rating');
            $table->string('commitment_on_task_delivery_rating');
            $table->string('technical_knowledge_rating');
            $table->string('logical_ability_rating');
            $table->string('attitude_rating');
            $table->string('overall_rating');
            $table->text('comments');
            $table->date('feedback_date');
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
