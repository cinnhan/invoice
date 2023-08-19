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
        Schema::create('invoice_fruit_items', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->string('fruit_item_name')->comment('fruit item name');
            $table->string('unit')->comment('unit: kg, pcs, pack');
            $table->unsignedDecimal('price', 19, 6);
            $table->unsignedBigInteger('category_id')->comment('category_id, foreign key');
            $table->string('category_name')->comment('category name');
            $this->commonColumns($table);
            $this->deletedColumn($table);

            $table->unique(['fruit_item_name'], implode('_', [$table->getTable(), 'fruit_item_name']));
            $table->index(['category_id'], implode('_', [$table->getTable(), 'category_id', 'index']));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_fruit_items');
    }
};
