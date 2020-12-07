<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_dues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->foreign('resignation_id')->references('id')->on('resignations');
            $table->string('knowledge_transfer_lead')->nullable();
            $table->string('knowledge_transfer_lead_comment')->nullable();
            $table->string('mail_id_closure_lead')->nullable();
            $table->string('mail_id_closure_lead_comment')->nullable();
            $table->string('knowledge_transfer_head')->nullable();
            $table->string('knowledge_transfer_head_comment')->nullable();
            $table->string('mail_id_closure_head')->nullable();
            $table->string('mail_id_closure_head_comment')->nullable();
            $table->string('id_card')->nullable();
            $table->string('id_card_comment')->nullable();
            $table->string('nda')->nullable();
            $table->string('nda_comment')->nullable();
            $table->string('official_email_id')->nullable();
            $table->string('official_email_id_comment')->nullable();
            $table->string('skype_account')->nullable();
            $table->string('skype_account_comment')->nullable();
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
        Schema::dropIfExists('no_dues');
    }
}
