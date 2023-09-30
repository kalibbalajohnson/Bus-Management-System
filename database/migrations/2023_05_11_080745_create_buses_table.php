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
        Schema::create('buses', function (Blueprint $table) {
            $table->string('numberPlate')->primary();
            $table->unsignedInteger('routeNo')->nullable();
            $table->foreign('routeNo')->references('routeNo')->on('routes')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedInteger('driver')->unique()->nullable();
            $table->foreign('driver')->references('staffNo')->on('staff')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedInteger('codriver')->unique()->nullable();
            $table->foreign('codriver')->references('staffNo')->on('staff')->onDelete('set null')->onUpdate('cascade');
            $table->string('status')->default('Parked');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
};
