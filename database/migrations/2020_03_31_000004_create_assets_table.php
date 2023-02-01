<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('category_id');
            $table->string('type');
            $table->string('unit')->nullable();
            $table->enum('status', ['0','1'])->default('0')->comment('0:Inactive,1:Active');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
