<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Role::where('name', 'LIKE', '% Supervisor%')->delete();
    }
};
