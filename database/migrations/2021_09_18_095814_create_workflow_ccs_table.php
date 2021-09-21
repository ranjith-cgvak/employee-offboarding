<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowCcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_cc', function (Blueprint $table) {
            $table->id();
            $table->enum('mail_type', ['Resignation ', 'No Due']);
            $table->string('resignation_department')->nullable();
            $table->unsignedBigInteger('cc_emp_id');
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
        Schema::dropIfExists('workflow_cc');
    }
}
