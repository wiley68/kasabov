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
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->string('first_color')->default('#ffffff');
            $table->string('second_color')->default('#ffffff');
            $table->enum('age', array('child', 'adult', 'any'));
            $table->enum('pol', array('man', 'woman', 'any'));
            $table->enum('condition', array('new', 'old'));
            $table->integer('send_id')->nullable();
            $table->integer('send_from_id')->nullable();
            $table->float('price_send')->default(0.00);
            $table->boolean('send_free')->default(false);
            $table->integer('send_free_id')->default(0);
            $table->enum('available_for', array('city', 'cities', 'area', 'country'))->default('country');
            $table->boolean('object')->default(false);
            $table->string('object_name')->nullable();
            $table->boolean('personalize');
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
