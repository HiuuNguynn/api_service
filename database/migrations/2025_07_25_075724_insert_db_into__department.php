<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Department;

class InsertDbIntoDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Department::create(
        [
            'code' => 1,
            'name' => 'IT',
            'manager_id' => 14,
        ]);

        Department::create([
            'code' => 2,
            'name' => 'HR',
            'manager_id' => 15,
        ]);

        Department::create([
            'code' => 3,
            'name' => 'Finance',
            'manager_id' => 16,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
