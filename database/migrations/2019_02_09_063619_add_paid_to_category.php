<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('categories', function($table) {
        
		$table->string('metatitle', 255);
		$table->string('metadescripation', 255);
		$table->string('metakeyword', 255);
		$table->string('banner', 255);
    });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('categories', function($table) {
         $table->dropColumn('banner');
		  $table->dropColumn('metakeyword');
		   $table->dropColumn('metadescripation');
		    $table->dropColumn('metatitle');
    });
        //
    }
}
