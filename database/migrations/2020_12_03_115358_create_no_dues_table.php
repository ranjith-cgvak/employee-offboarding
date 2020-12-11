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
            $table->text('knowledge_transfer_lead_comment')->nullable();
            $table->string('mail_id_closure_lead')->nullable();
            $table->text('mail_id_closure_lead_comment')->nullable();
            $table->string('knowledge_transfer_head')->nullable();
            $table->text('knowledge_transfer_head_comment')->nullable();
            $table->string('mail_id_closure_head')->nullable();
            $table->text('mail_id_closure_head_comment')->nullable();
            $table->string('id_card')->nullable();
            $table->text('id_card_comment')->nullable();
            $table->string('nda')->nullable();
            $table->text('nda_comment')->nullable();
            $table->string('official_email_id')->nullable();
            $table->text('official_email_id_comment')->nullable();
            $table->string('skype_account')->nullable();
            $table->text('skype_account_comment')->nullable();
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
