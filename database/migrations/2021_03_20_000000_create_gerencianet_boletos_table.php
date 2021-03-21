<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGerencianetBoletosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gerencianet_boletos', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('gerencianet_boleto_method_id');
            $table->unsignedBigInteger('subscription_invoice_id');
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gerencianet_charge_id');
            $table->string('name');
            $table->string('cpf', 11);
            $table->string('phone', 11);
            $table->string('gerencianet_boleto_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('gerencianet_boletos');
    }

}
