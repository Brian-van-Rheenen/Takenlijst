<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTakenWerknemerid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('taken', 'werknemer_id')){
            Schema::table('taken', function (Blueprint $table) {
                $table->dropColumn('werknemer_id');
            });
        }

        Schema::table('taken', function (Blueprint $table) {
            $table->integer('werknemer_id')->nullable()->after('taak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
