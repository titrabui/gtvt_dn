<?php

namespace Fuel\Migrations;

class Create_measuring_values
{
	public function up()
	{
		\DBUtil::create_table('measuring_values', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'measuring_point_id' => array('constraint' => 11, 'type' => 'int'),
			'total_time_surveying' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'weather' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'value1' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'value2' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'value3' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('measuring_values');
	}
}