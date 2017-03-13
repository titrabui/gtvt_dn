<?php

namespace Fuel\Migrations;

class Create_measuring_points
{
	public function up()
	{
		\DBUtil::create_table('measuring_points', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'project_id' => array('constraint' => 11, 'type' => 'int'),
			'name' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'location' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'x_coordinate' => array('type' => 'double', 'null' => true),
			'y_coordinate' => array('type' => 'double', 'null' => true),
			'road_height' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'account' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
			'battery' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'is_request' => array('constraint' => 1, 'type' => 'tinyint', 'null' => true),
			'note' => array('constraint' => 1000, 'type' => 'varchar', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('measuring_points');
	}
}