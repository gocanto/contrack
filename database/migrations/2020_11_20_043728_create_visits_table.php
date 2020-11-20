<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up(): void
    {
        Schema::create('visits', static function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('visitor_first_name');
            $table->string('visitor_last_name');
            $table->string('phone_number');
            $table->string('nric_last_r');

            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('block_id')->constrained('blocks');

            $table->dateTime('arrived_at');
            $table->dateTime('left_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
}
