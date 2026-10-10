<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->change();
        });

        // Laboratory 3 role mapping: requester -> student
        DB::table('users')->where('role', 'requester')->update(['role' => 'student']);

        // Laboratory 3 role mapping: staff_reviewer and record_keeper -> administrator
        DB::table('users')->whereIn('role', ['staff_reviewer', 'record_keeper'])->update(['role' => 'administrator']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'student')->update(['role' => 'requester']);
        DB::table('users')->where('role', 'administrator')->update(['role' => 'record_keeper']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('requester')->change();
        });
    }
};
