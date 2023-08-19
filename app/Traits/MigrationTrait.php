<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait MigrationTrait
{

    /**
     * create Common Columns
     * @param Blueprint $table
     * @return void
     */
    public function commonColumns(Blueprint $table): void
    {
        $table->dateTime('created_at')->comment('created at');
        $table->string('created_by')->comment('created by');
        $table->dateTime('updated_at')->nullable()->comment('updated at');
        $table->string('updated_by')->nullable()->comment('updated by');
    }

    /**
     * create Deleted Column
     * @param Blueprint $table
     * @return void
     */
    public function deletedColumn(Blueprint $table)
    {
        $table->softDeletes();
    }

}
