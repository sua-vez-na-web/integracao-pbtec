<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeikoNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geiko_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id')->nullable();
            $table->string('message')->nullable();
            $table->dateTime('include_at')->nullable();
            $table->dateTime('removed_at')->nullable();
            $table->integer('customer_id')->nullable();
            $table->boolean('is_sent')->nullable();
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
        Schema::dropIfExists('geiko_notifications');
    }
}
