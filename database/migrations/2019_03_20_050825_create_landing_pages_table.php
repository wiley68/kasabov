<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header_title', 48)->nullable();
            $table->string('header_subtitle', 128)->nullable();
            $table->string('category_title', 48)->nullable();
            $table->string('best_title', 48)->nullable();
            $table->string('best_subtitle', 128)->nullable();
            $table->string('featured_title', 48)->nullable();
            $table->string('featured_subtitle', 128)->nullable();
            $table->string('works_title', 48)->nullable();
            $table->string('works_subtitle', 128)->nullable();
            $table->string('create_account', 48)->nullable();
            $table->string('post_add', 48)->nullable();
            $table->string('deal_done', 48)->nullable();
            $table->string('key_title', 48)->nullable();
            $table->string('key_subtitle', 128)->nullable();
            $table->string('key_title1', 48)->nullable();
            $table->string('key_description1', 128)->nullable();
            $table->string('key_icon1', 48)->nullable();
            $table->string('key_title2', 48)->nullable();
            $table->string('key_description2', 128)->nullable();
            $table->string('key_icon2', 48)->nullable();
            $table->string('key_title3', 48)->nullable();
            $table->string('key_description3', 128)->nullable();
            $table->string('key_icon3', 48)->nullable();
            $table->string('key_title4', 48)->nullable();
            $table->string('key_description4', 128)->nullable();
            $table->string('key_icon4', 48)->nullable();
            $table->string('key_title5', 48)->nullable();
            $table->string('key_description5', 128)->nullable();
            $table->string('key_icon5', 48)->nullable();
            $table->string('key_title6', 48)->nullable();
            $table->string('key_description6', 128)->nullable();
            $table->string('key_icon6', 48)->nullable();
            $table->string('testimonials_description1', 256)->nullable();
            $table->string('testimonials_name1', 48)->nullable();
            $table->string('testimonials_title1', 48)->nullable();
            $table->string('testimonials_description2', 256)->nullable();
            $table->string('testimonials_name2', 48)->nullable();
            $table->string('testimonials_title2', 48)->nullable();
            $table->string('testimonials_description3', 256)->nullable();
            $table->string('testimonials_name3', 48)->nullable();
            $table->string('testimonials_title3', 48)->nullable();
            $table->string('footer_text', 256)->nullable();
            $table->string('footer_phone1', 48)->nullable();
            $table->string('footer_phone2', 48)->nullable();
            $table->string('footer_mail1', 48)->nullable();
            $table->string('footer_mail2', 48)->nullable();
            $table->string('footer_address', 128)->nullable();
            $table->string('footer_rites', 256)->nullable();
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
        Schema::dropIfExists('landing_pages');
    }
}
