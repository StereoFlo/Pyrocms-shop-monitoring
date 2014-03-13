<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Monitoring extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Shop Monitoring',
				'ru' => 'Мониторинг ССМ'
			),
			'description' => array(
				'en' => 'Shop monitoring',
				'ru' => 'Мониторинг магазинов'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'utilities',
			'sections' => array(
				'monitoring' => array(
				    'name' => 'admin_monitoring',
				    'uri' => 'admin/monitoring',
					'shortcuts'	=> array(
						array(
					 	   'name'	=> 'admin_shortcuts_add_shop',
						   'uri'	=> 'admin/monitoring/add',
						   'class'	=> 'add'
						)
					)
				),
				'providers' => array(
				    'name' => 'admin_monitoring_providers',
				    'uri' => 'admin/monitoring/providers/',
					'shortcuts'	=> array(
						array(
					 	   'name'	=> 'admin_shortcuts_add_provider',
						   'uri'	=> 'admin/monitoring/providers/add/',
						   'class'	=> 'add'
						)
					)
				),
				'networks' => array(
				    'name' => 'admin_monitoring_networks',
				    'uri' => 'admin/monitoring/networks/',
				),
				'phones' => array(
				    'name' => 'admin_monitoring_phones',
				    'uri' => 'admin/monitoring/phones/',
				),
				'shop' => array(
					'shortcuts'	=> array(
						array(
					 	   'name'	=> 'admin_monitoring_shop_notice_add',
						   'uri'	=> 'admin/monitoring/shop/notice',
						   'class'	=> 'add'
						)
					)
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('monitoring_shops');
		$this->dbforge->drop_table('monitoring_providers');
		$this->dbforge->drop_table('monitoring_networks');
		$this->dbforge->drop_table('monitoring_device_types');
		$this->dbforge->drop_table('monitoring_local_networks');
		$this->dbforge->drop_table('monitoring_filials');
		$this->dbforge->drop_table('monitoring_notice');
		$this->dbforge->drop_table('monitoring_phone_pools');
		$this->dbforge->drop_table('monitoring_phones');
		$this->dbforge->drop_table('monitoring_regions');
	
		$monitoring_shops = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_shops')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				region_id int(11) DEFAULT NULL,
				code varchar(255) DEFAULT NULL,
				name varchar(255) DEFAULT NULL,
				address varchar(255) DEFAULT NULL,
				state varchar(255) DEFAULT NULL,
				tmode int(11) DEFAULT NULL,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Магазины';
		";		

		$monitoring_providers = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_providers')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(50) DEFAULT NULL,
				dogovor varchar(255) DEFAULT NULL,
				manager_phone varchar(255) DEFAULT NULL,
				tech_phone varchar(255) DEFAULT NULL,
				comment varchar(255) DEFAULT NULL,
				date timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Магазины';
		";			

		$monitoring_networks = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_networks')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				provider_id int(11) DEFAULT NULL,
				shop_id int(11) DEFAULT NULL,
				type varchar(255) DEFAULT NULL,
				ip varchar(255) DEFAULT NULL,
				mask varchar(255) DEFAULT NULL,
				gate varchar(255) DEFAULT NULL,
				speed varchar(255) DEFAULT NULL,
				comment varchar(255) DEFAULT NULL,
				state int(11) DEFAULT 0,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Сети';
		";	

		$monitoring_device_types = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_device_types')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(50) DEFAULT NULL,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Типы устройств';
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (1, 'Astaro');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (2, 'Компьютер');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (3, 'Принтер');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (4, 'Телефон');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (5, 'Счетчик почетителей');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (6, 'Видеорегистратор');
			INSERT INTO ".$this->db->dbprefix('monitoring_device_types')."(id, name) VALUES (7, 'Медиаплеер');
		";
		
		$monitoring_local_networks = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_local_networks')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				shop_id int(11) DEFAULT NULL,
				ip varchar(255) DEFAULT NULL,
				host varchar(255) DEFAULT NULL,
				state varchar(255) DEFAULT NULL,
				type varchar(255) DEFAULT NULL,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Локальные сети';
		";
		
		$monitoring_filials = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_filials')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(50) DEFAULT NULL,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Филиалы';
		";
		$monitoring_notice = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_notice')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				notice_id varchar(255) DEFAULT NULL,
				shop_id int(11) DEFAULT NULL,
				subject varchar(255) DEFAULT NULL,
				comment varchar(255) DEFAULT NULL,
				email varchar(255) DEFAULT NULL,
				date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Уведомления';
		";
		$monitoring_phone_pools = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_phone_pools')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(50) DEFAULT NULL,
				start varchar(255) DEFAULT NULL,
				end varchar(255) DEFAULT NULL,
				date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Пулы номеров';
		";
		$monitoring_phones = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_phones')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				pool_id int(11) DEFAULT NULL,
				shop_id int(11) DEFAULT NULL,
				phone varchar(255) DEFAULT NULL,
				date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Номера';
		";
		$monitoring_regions = "
			CREATE TABLE ".$this->db->dbprefix('monitoring_regions')." (
				id int(11) NOT NULL AUTO_INCREMENT,
				filial_id int(11) DEFAULT NULL,
				name varchar(50) DEFAULT NULL,
				PRIMARY KEY (id)
			      )
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Номера';
		";

		
		if($this->db->query($monitoring_shops)
		   and $this->db->query($monitoring_providers)
		   and $this->db->query($monitoring_networks)
		   and $this->db->query($monitoring_device_types)
		   and $this->db->query($monitoring_local_networks)
		   and $this->db->query($monitoring_filials)
		   and $this->db->query($monitoring_notice)
		   and $this->db->query($monitoring_phone_pools)
		   and $this->db->query($monitoring_phones)
		   and $this->db->query($monitoring_regions))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('monitoring_shops');
		$this->dbforge->drop_table('monitoring_providers');
		$this->dbforge->drop_table('monitoring_networks');
		$this->dbforge->drop_table('monitoring_device_types');
		$this->dbforge->drop_table('monitoring_local_networks');
		$this->dbforge->drop_table('monitoring_filials');
		$this->dbforge->drop_table('monitoring_notice');
		$this->dbforge->drop_table('monitoring_phone_pools');
		$this->dbforge->drop_table('monitoring_phones');
		$this->dbforge->drop_table('monitoring_regions');
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}