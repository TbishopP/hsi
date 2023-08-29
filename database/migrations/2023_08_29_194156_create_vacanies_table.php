<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('internal_reference')->nullable();
            $table->string('job_title');
            $table->foreignId('country_id')->constrained();
            $table->string('location');
            $table->string('postcode');
            $table->string('display_location')->nullable();
            $table->foreignId('salary_range_id')->constrained();
            $table->boolean('hide_salary')->nullable();
            $table->string('bonus_benefits');
            $table->longText('description');
            $table->string('contract_duration')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('employer_logo')->nullable();
            $table->string('repsonse_method');
            $table->string('response_action');
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_telephone')->nullable();
            $table->boolean('cover_letter')->nullable();
            $table->boolean('featured')->nullable();
            $table->boolean('suspended')->nullable();
            $table->boolean('draft')->nullable();
            $table->dateTime('posting_start_date');
            $table->dateTime('expiry_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacanies');
    }
};
