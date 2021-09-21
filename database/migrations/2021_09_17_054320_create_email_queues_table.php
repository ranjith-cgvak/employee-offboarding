<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from', 255);
            $table->text('to')->comment('Comma Separated');
            $table->string('cc')->comment('Comma Separated');
            $table->string('bcc')->comment('Comma Separated');
            $table->string('subject');
            $table->text('message')->nullable();
			$table->string('template', 255)->nullable();
			$table->text('template_details')->nullable();
			$table->text('attachments')->comment('Comma Separated')->nullable();
            $table->integer('error')->default(0);
            $table->string('error_message',1000)->nullable();
			$table->enum('priority', [1, 2, 3])->comment('1 => Notifications, 2=> Reminders, 3=> Wishes & One Year Completion');
			$table->boolean('status')->default(0)->comment('0 => Pending, 1=> Processed');
			$table->index(['priority','status']);
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
        Schema::dropIfExists('email_queues');
    }
}
