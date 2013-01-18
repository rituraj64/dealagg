<?php
class Category{
	const MOBILE = 1;
	const TABLETS = 2;
	const TV = 3;
	const GAMING = 4;
	const COMP_LAPTOP = 5;
	const COMP_ACC = 6;
	const CAMERA = 7;
	const NUTRITION = 8;
	const BOOKS = 9;
	const HOME_APPLIANCE = 10;
	const BEAUTY  =11;
	const MOBILE_ACC = 12;
	const CAMERA_ACC = 13;

	const NOT_SURE = 0;

	const CAM_DIGITAL_CAMERA = 701;
	const CAM_CAMCORDER = 702;
	const CAM_DIGITAL_SLR = 703;
	const CAM_MIRRORLESS = 704;

	const CAM_ACC_MEMORY_AND_STORAGE = 1301;
	const CAM_ACC_LENSES = 1302;
	const CAM_ACC_BATTERY = 1303;
	const CAM_ACC_SCREEN_PROTECTOR = 1304;
	const CAM_ACC_FLASH_LIGHTS = 1305;
	const CAM_ACC_BAGS = 1306;
	const CAM_ACC_OTHER_ACC = 1307;
	const CAM_ACC_ADAPTER_CHARGES = 1309;
	const CAM_ACC_TRIPODS = 1308;
	const CAM_ACC_LENSEFILTER = 1309;

	const MOB_CASES = 1201;
	const MOB_SCREEN_GUARD = 1202;
	const MOB_HEADPHONE = 1203;
	const MOB_HEADSETS = 1204;
	const MOB_CHARGER = 1205;
	const MOB_CAR_ACC = 1206;
	const MOB_CABLE = 1207;
	const MOB_MEMORY= 1208;
	const MOB_SPEAKER = 1209;
	const MOB_BATTERY = 1210;
	const MOB_OTHERS = 1211;
	const MOB_HANDSFREE = 1212;

	const COMP_COMPUTER = 501;
	const LAPTOP_ACC = 502;


	const COMP_ACC_PEN_DRIVE = 601;
	const COMP_ACC_EXTERNAL_HARD_DRIVE = 602;
	const COMP_ACC_SOFTWARE = 603;
	const COMP_ACC_PRINTER_SCANNER = 604;
	const COMP_ACC_CARTRIGES = 605;
	const COMP_ACC_KEYBOARD = 606;
	const COMP_ACC_MOUSE = 607;
	const COMP_ACC_SPEAKERS = 608;
	const COMP_ACC_COMPUTER_COMPONENTS = 609;
	const COMP_ACC_MONITERS = 610;
	const COMP_ACC_NETWORK = 611;

	const GAMING_ACC_GAMES = 401;
	const GAMING_ACC_CONSOLES = 403;
	const GAMING_ACC_ACC = 403;

	public function getStoreCategory(){
		return array(
				self::MOBILE =>'Mobiles',
				self::MOBILE_ACC =>array('Mobiles Accessories'=>array(
						self::MOB_MEMORY => 'Memory Cards - MicroSD Cards',
						self::MOB_BATTERY => 'Batteries',
						//self::MOB_CHARGER => 'Chargers',
						//self::MOB_CASES => 'Cases & Covers',
						//self::MOB_SCREEN_GUARD => 'Screen Protectors',
						self::MOB_HEADPHONE => 'Headphone',
						self::MOB_HEADSETS => 'Headsets - Bluetooth',
						self::MOB_CAR_ACC => 'Car Accessories',
						//self::MOB_CABLE => 'Cables - Data Cables',
						self::MOB_SPEAKER => 'Speakers',
						self::MOB_HANDSFREE => 'Handsfree',
						//self::MOB_OTHERS => 'Other Accessories'
				)),
				self::TABLETS=>'Tablets, iPad',
				self::TV=>'Television',
				self::GAMING =>array('Gaming'=>array(
						self::GAMING_ACC_CONSOLES => 'Gaming Consoles',
						self::GAMING_ACC_GAMES => 'Games Software',
						self::GAMING_ACC_ACC => 'Gaming Accessories'
				)),
				self::COMP_LAPTOP=>array('Computer & Laptop'=>array(
						self::COMP_COMPUTER => 'Computers - Desktops',
						self::COMP_LAPTOP => 'Laptops'
				)),
				self::COMP_ACC=>array('Computer,Laptop Accessories & Software'=>array(
						self::COMP_ACC_PEN_DRIVE => 'Pen Drives & Memory Cards',
						self::COMP_ACC_EXTERNAL_HARD_DRIVE => 'External Hard Disk',
						self::COMP_ACC_PRINTER_SCANNER => 'Printers & Scanner',
						self::COMP_ACC_CARTRIGES => 'Printer Cartriges',
						self::COMP_ACC_COMPUTER_COMPONENTS => 'Computer Components - RAM,CPU,Processor,etc',
						self::COMP_ACC_KEYBOARD => 'Keyboards',
						self::COMP_ACC_MOUSE => 'Mouse',
						self::COMP_ACC_MONITERS => 'Monter - LCD,TFT,etc',
						self::COMP_ACC_NETWORK => 'Wireless Adapters - Routers - Modems - etc',
						self::COMP_ACC_SOFTWARE => 'Software',
						self::COMP_ACC_SPEAKERS => 'Speakers',
				)),
				self::CAMERA=>array('Cameras'=>array(
						self::CAM_DIGITAL_CAMERA => 'Digital Camera - Point & Shoot',
						self::CAM_DIGITAL_SLR => 'DSLR - Digital SLR',
						self::CAM_CAMCORDER => 'Camcorder - Video Recorder',
						self::CAM_MIRRORLESS => 'Mirrorless Camera'
				)),
				self::CAMERA_ACC => array('Camera Accessories'=>array(
						self::CAM_ACC_MEMORY_AND_STORAGE => 'Memory Cards - Storage',
						self::CAM_ACC_LENSES => 'Lenses',
						self::CAM_ACC_LENSES => 'Lens Filters',
						self::CAM_ACC_BATTERY => 'Battery',
						self::CAM_ACC_ADAPTER_CHARGES => 'Adapters & Chargers',
						self::CAM_ACC_SCREEN_PROTECTOR => 'Screen Protectors',
						self::CAM_ACC_FLASH_LIGHTS => 'Flash & Lightings',
						self::CAM_ACC_BAGS => 'Bags, Cases or Pouches',
						self::CAM_ACC_TRIPODS => 'Tripods, Monopods',
						self::CAM_ACC_OTHER_ACC => 'Other Accessories'
				)),
				//self::NUTRITION=>'Nutrition',
				self::BOOKS=>'Books',
				//self::HOME_APPLIANCE=>'Home Appliances',
				//self::BEAUTY=>'Health & Beauty'
		);

		//other section we can see
		//1. gift 2. baby care 3. music 4. toys 5. ebooks 6. Movies 7. mobile recharge 8. automobile acc
		//9. baby products


		//can include photo digital frame, binoculars,
	}
}