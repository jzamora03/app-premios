<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrizeToParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('participants', function (Blueprint $table) {
        $table->foreignId('prize_id')->nullable()->constrained('prizes')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('participants', function (Blueprint $table) {
        $table->dropForeign(['prize_id']);
        $table->dropColumn('prize_id');
    });
}

}
