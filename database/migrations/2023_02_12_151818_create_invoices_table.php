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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection',8,2)->nullable();
            $table->decimal('amount_commision',8,2)->nullable();
            $table->decimal('discount',8,2);
            $table->decimal('value_vat',8,2);
            $table->string('rate_vat');
            $table->decimal('total',8,2);
            $table->string('status',50);
            $table->string('value_status');
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('user');
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
