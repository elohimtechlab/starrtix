<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('general_setting')) {
            Schema::create('general_setting', function (Blueprint $table) {
                $table->id();
                $table->string('app_name')->default('StarrTix');
                $table->string('currency', 10)->default('USD');
                $table->string('currency_symbol', 10)->default('$');
                $table->string('language', 10)->default('en');
                $table->string('timezone')->default('UTC');
                $table->string('logo')->nullable();
                $table->string('favicon')->nullable();
                $table->timestamps();
            });

            // Insert default settings
            DB::table('general_setting')->insert([
                'app_name' => 'StarrTix',
                'currency' => 'USD',
                'currency_symbol' => '$',
                'language' => 'en',
                'timezone' => 'UTC',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_setting');
    }
}
