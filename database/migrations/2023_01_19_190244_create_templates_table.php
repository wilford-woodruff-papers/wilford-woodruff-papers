<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('templates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('type_id')
                    ->constrained();
                $table->string('name');
                $table->timestamps();
            });

            Schema::create('properties', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->string('type');
                $table->string('width');
                $table->string('comment')->nullable();
                $table->boolean('multivalue')->default(false);
                $table->timestamps();
            });

            Schema::create('property_template', function (Blueprint $table) {
                $table->id();
                $table->foreignId('template_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->foreignId('property_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->boolean('is_required')->default(false);
                $table->unsignedInteger('order_column');
                $table->timestamps();
            });

            Schema::create('values', function (Blueprint $table) {
                $table->id();
                $table->foreignId('item_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->foreignId('property_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('value', 1024)->nullable();
                $table->boolean('not_found')->default(false);
                $table->timestamps();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
            });
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            $this->down();
            throw $exception;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('values');
        Schema::dropIfExists('property_template');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('templates');
    }
};
