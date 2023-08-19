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
        Schema::create('invoice_invoice_items', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->unsignedBigInteger('invoice_id')->comment('invoice_id, foreign key');
            $table->unsignedBigInteger('fruit_id')->comment('fruit_id, foreign key');
            $table->string('fruit_name')->comment('fruit name');
            $table->unsignedBigInteger('category_id')->comment('category_id, foreign key');
            $table->string('category_name')->comment('category name');
            $table->string('unit')->comment('unit: kg, pcs, pack');
            $table->unsignedDecimal('price', 19, 6)->comment('price');
            $table->unsignedInteger('quantity')->comment('quantity');
            $table->unsignedDecimal('amount', 19, 6)->comment('amount');
            $this->commonColumns($table);
            $this->deletedColumn($table);

            $table->unique(['invoice_id', 'fruit_id'], implode('_', [$table->getTable(), 'invoice_id', 'fruit_id', 'unique']));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_invoice_items');
    }
};
