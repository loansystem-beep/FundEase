<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisbursersTable extends Migration
{
    public function up()
    {
        Schema::create('disbursers', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the disburser
            $table->text('description')->nullable();  // Description of the disburser
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disbursers');
    }
}
