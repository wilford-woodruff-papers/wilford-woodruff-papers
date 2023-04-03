<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $types = \App\Models\Type::query()
                                    ->whereNull('type_id')
                                    ->get();

        $types->each(function ($type) {
            $role = \App\Models\Role::create([
                'name' => $type->name.' Editor',
            ]);
            $type->assignRole($role);
            if ($type->subType) {
                $type->subType->assignRole($role);
            }
        });

        $actionTypes = \App\Models\ActionType::all();

        $actionTypes->each(function ($actionType) {
            $role = \App\Models\Role::create([
                'name' => $actionType->name,
            ]);
            $actionType->assignRole($role);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        \App\Models\Role::where('name', 'LIKE', '% Editor%')->delete();
    }
};
