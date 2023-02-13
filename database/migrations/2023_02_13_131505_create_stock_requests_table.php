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
        Schema::create('stock_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->float('stock')->nullable();
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('team_id')->nullable();
            $table->enum('status', ['0','1','2'])->default('0')->comment('0:Pending,1:Confirm,2:Cancled');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_requests');
    }
};
