<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('event_id');
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('invite_type'); // speaker, vip, sponsor, media, staff, general
            $table->text('invite_message')->nullable();
            $table->string('invite_token')->unique(); // unique token for invite URL
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['event_id', 'status']);
            $table->index('invite_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_invites');
    }
}
