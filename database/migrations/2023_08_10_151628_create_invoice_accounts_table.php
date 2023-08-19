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
        Schema::create('invoice_accounts', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->string('full_name')->comment('full name');
            $table->string('email')->comment('email');
            $table->string('password')->comment('password');
            $table->dateTime('email_verified_at')->nullable();
            $table->rememberToken();
            $table->dateTime('last_time_login')->nullable()->comment('last time login');
            $this->commonColumns($table);
            $this->deletedColumn($table);

            $table->unique(['email'], implode('_', [$table->getTable(), 'email', 'unique']));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_accounts');
    }
};
