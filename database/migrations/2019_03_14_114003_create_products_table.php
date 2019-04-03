<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('holiday_id')->default(0);
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->string('first_color')->default('white');
            $table->string('second_color')->default('white');
            $table->enum('age', array('child', 'adult', 'any'))->default('any');
            $table->enum('pol', array('man', 'woman', 'any'))->default('any');
            $table->enum('condition', array('new', 'old'))->default('new');
            $table->integer('send_id')->default(0);
            $table->integer('send_from_id')->default(0);
            $table->float('price_send')->default(0.00);
            $table->boolean('send_free')->default(0);
            $table->integer('send_free_id')->default(0);
            $table->enum('available_for', array('city', 'cities', 'area', 'country'))->default('country');
            $table->boolean('object')->default(0);
            $table->string('object_name')->default('');
            $table->boolean('personalize')->default(0);
            $table->text('description');
            $table->integer('quantity')->default(1);
            $table->float('price');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
