<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_abouts', function (Blueprint $table) {
            $table->id();
            $table->char('ulid', 26)->unique();
            $table->char('name', 255);
            $table->char('email', 255);
            $table->string('message');
            $table->char('lang', 26);
            $table->timestamps();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('lang')
                ->references('ulid')
                ->on('languages')
                ->comment('ссылка на языковую версию');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_abouts');
    }
}
