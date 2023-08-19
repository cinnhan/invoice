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
        Schema::create('invoice_invoice_info', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->string('code', 100)->comment('code, unique key');
            $table->string('customer_name')->comment('customer name');
            $table->unsignedDecimal('total_amount', 19, 6)->comment('total amount');
            $this->commonColumns($table);
            $this->deletedColumn($table);

            $table->unique(['code'], implode('_', [$table->getTable(), 'code', 'unique']));
            $table->index(['created_by'], implode('_', [$table->getTable(), 'created_by', 'index']));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_invoice_info');
    }
};
