<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->boolean('gender');
            $table->boolean('status')->default(1);
            $table->string('date');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('city');
            $table->string('specialty');
            // $table->foreignIdFor(Role::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
