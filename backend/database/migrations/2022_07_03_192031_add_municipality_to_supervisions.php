<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMunicipalityToSupervisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisions', function (Blueprint $table) {
            //
            $table->foreignId('municipality_id')
                ->nullable()
                ->constrained()
                ->onDelete('No action')
                ->onUpdate('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisions', function (Blueprint $table) {
            //
        });
    }
}
