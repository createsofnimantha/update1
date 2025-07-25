<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('books', function (Blueprint $table) {
        $table->unsignedBigInteger('category_id')->after('user_id');
        $table->unsignedBigInteger('subcategory_id')->after('category_id');

        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropForeign(['subcategory_id']);
        $table->dropColumn(['category_id', 'subcategory_id']);
    });
}

};
