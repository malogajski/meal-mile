<?php

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
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('owner_id')->after('name')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('team_code')->after('name')->nullable();
        });

        $teams = \App\Models\Team::all();
        foreach ($teams as $team) {
            $team->team_code = $this->generateTeamCode();
            $team->save();
        }
        Schema::table('teams', function (Blueprint $table) {
            $table->string('team_code')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('team_code');
            $table->dropConstrainedForeignId('owner_id');
        });
    }

    protected function generateTeamCode($length = 8): string
    {
        return strtoupper(substr(md5(uniqid()), 0, $length));
    }
};
