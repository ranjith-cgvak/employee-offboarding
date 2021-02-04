<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptanceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceptance_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->foreign('resignation_id')->references('id')->on('resignations');
            $table->string('acceptance_status')->default('Pending');
            $table->enum('reviewed_by', ['lead', 'head', 'hr']);
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
        Schema::dropIfExists('acceptance_statuses');
    }
}
