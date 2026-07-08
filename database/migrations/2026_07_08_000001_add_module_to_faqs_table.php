<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('module', 32)->default('general')->after('is_active')->index();
        });

        // Existing seed content is venture-oriented; reclassify known rows.
        DB::table('faqs')->update(['module' => 'venture']);
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('module');
        });
    }
};
