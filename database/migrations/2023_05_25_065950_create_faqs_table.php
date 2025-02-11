<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id');
            $table->integer('category_id');
            $table->string('degree')->nullable();
            $table->string('subjects')->nullable();
            $table->string('question_zh');
            $table->longText('answer_zh');
            $table->string('question_en')->nullable();
            $table->text('answer_en')->nullable();
            $table->string('question_pt')->nullable();
            $table->text('answer_pt')->nullable();
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
        Schema::dropIfExists('faqs');
    }
};
