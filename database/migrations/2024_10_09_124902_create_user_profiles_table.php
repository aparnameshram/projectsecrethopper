<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->string('timezone');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('drinker_type');
            $table->text('how_did_hear');
            $table->text('recent_experience');
            $table->text('qualification_for_hopper');
            $table->text('acknowledge_text');
            $table->string('acknowledge_name');
            $table->date('date_signed');
            $table->boolean('practice_report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
