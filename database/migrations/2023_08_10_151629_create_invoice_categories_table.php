<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;

return new class extends Migration
{
    use MigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_categories', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->string('category_name')->comment('category name');
            $this->commonColumns($table);
            $this->deletedColumn($table);

            $table->unique(['category_name'], implode('_', [$table->getTable(), 'category_name', 'unique']));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_categories');
    }
};
