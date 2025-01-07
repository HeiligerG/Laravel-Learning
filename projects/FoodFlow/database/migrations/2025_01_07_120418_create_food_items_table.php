<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryFoodItemTable extends Migration
{
    public function up()
    {
        Schema::create('category_food_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('food_item_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('food_item_id')->references('id')->on('food_items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_food_item');
    }
};
