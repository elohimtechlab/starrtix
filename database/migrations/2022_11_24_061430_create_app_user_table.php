<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->boolean('status')->default(1);
            $table->text('following')->nullable();
            $table->string('provider')->nullable();
            $table->text('favorite')->nullable();
            $table->text('favorite_blog')->nullable();
            $table->string('phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->text('bio')->nullable();
            $table->string('provider_token')->nullable();
            $table->string('device_token')->nullable();
            $table->string('language')->default('en');
            $table->boolean('is_verify')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('app_user');
    }
}
