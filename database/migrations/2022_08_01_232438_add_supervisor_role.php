<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $types = \App\Models\Type::query()
            ->whereNull('type_id')
            ->get();

        $types->each(function ($type) {
            $role = \App\Models\Role::create([
                'name' => $type->name.' Supervisor',
            ]);
            $type->assignRole($role);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Role::where('name', 'LIKE', '% Supervisor%')->delete();
    }
};