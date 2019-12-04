<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transacao extends Migration
{
	public function up()
	{
		$this->forge->addField([

			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'null'           => FALSE,
			],
			'id_pedido'       => [
				'type'           => 'INT',
				'constraint'     => 11,

				'null'           => FALSE,
			],
			'id_cliente' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'           => FALSE,
			],
			'codigo_transacao' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => FALSE,
			],
			'tipo_transacao' => [
				'type'           => 'TINYINT',
				'constraint'     => 1,
				'null'           => TRUE,
			],
			'referencia_transacao' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => FALSE,
			],
			'status_transacao' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => FALSE,
			],
			'valor_transacao' => [
				'type'           => 'DOUBLE',
				'null'           => FALSE,
			],
			'url_boleto' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'null'           => TRUE,
			],
			'created_at' => [
				'type'           => 'DATETIME',
				'null'           => FALSE,
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'           => FALSE,
			],
			'deleted_at' => [
				'type'           => 'DATETIME',
				'null'           => TRUE,
			],
		]);

		$this->forge->addKey('id', TRUE);

		$attributes = ['ENGINE' => 'InnoDB'];
		$this->forge->createTable('transacao', TRUE, $attributes);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transacao');
	}
}
