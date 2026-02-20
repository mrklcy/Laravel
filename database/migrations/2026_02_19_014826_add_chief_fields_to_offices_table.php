<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->string('chief_name')->nullable()->after('overview');
            $table->string('chief_email')->nullable()->after('chief_name');
        });

        // Seed the chief data for each office
        DB::table('offices')->where('code', 'HRMO')->update([
            'chief_name' => 'Mr. Jonathan T. Gurion',
            'chief_email' => 'jonathan.gurion@clsu.edu.ph',
        ]);

        DB::table('offices')->where('code', 'PMO')->update([
            'chief_name' => 'Mr. Ronnie Gutierrez',
            'chief_email' => 'ronnie.gutierrez@clsu.edu.ph',
        ]);

        DB::table('offices')->where('code', 'RMO')->update([
            'chief_name' => 'Ms. Loida A. Gurion',
            'chief_email' => 'loida.gurion@clsu.edu.ph',
        ]);

        DB::table('offices')->where('code', 'PSO')->update([
            'chief_name' => 'Mr. Jose Ariel G. Barza',
            'chief_email' => 'joseariel.barza@clsu.edu.ph',
        ]);
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn(['chief_name', 'chief_email']);
        });
    }
};
