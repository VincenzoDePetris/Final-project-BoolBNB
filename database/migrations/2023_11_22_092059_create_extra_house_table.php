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
        Schema::create('extra_house', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('house_id')
            ->constrained()
            ->cascadeOnDelete();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_house');
    }
};
