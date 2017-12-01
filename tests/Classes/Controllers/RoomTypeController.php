<?php

use PHPUnit\Framework\TestCase;

require "../../../src/Classes/Controllers/RoomTypeController.php";
require "../../../src/Classes/Entities/RoomInfoEntity.php";
require "../../../src/Classes/Entities/RoomImageEntity.php";
require "../../../src/Classes/Models/RoomInfoGenerator.php";
require "../../../src/Classes/Models/RoomImageGenerator.php";
require "../../../vendor/psr/log/Psr/Log/LoggerInterface.php";
require "../../../vendor/monolog/monolog/src/Monolog/Logger.php";

class RoomTypeControllerTest extends TestCase
{
    public function testGetRoomTypesSuccess()
    {
        $roomInfoEntity = $this->createMock(App\Classes\Entities\RoomInfoEntity::class);
        $id = 2;
        $name = 'Bob';
        $pricePerNight = 12;
        $numberOfAdults = 13;
        $hasCot = 1;
        $minStay = 14;
        $numberInHotel = 15;
        $description = 'bla';

        $roomInfoEntity->id = $id;
        $roomInfoEntity->name = $name;
        $roomInfoEntity->pricePerNight = $pricePerNight;
        $roomInfoEntity->numberOfAdults = $numberOfAdults;
        $roomInfoEntity->hasCot = $hasCot;
        $roomInfoEntity->minStay = $minStay;
        $roomInfoEntity->numberInHotel = $numberInHotel;
        $roomInfoEntity->description = $description;

        $roomInfoArray = [$roomInfoEntity, $roomInfoEntity];

        $roomInfoGenerator = $this->createMock(App\Classes\Models\RoomInfoGenerator::class);
        $roomInfoGenerator->method('getRoomsInfo')->willReturn($roomInfoArray);

        $roomImageEntity = $this->createMock(App\Classes\Entities\RoomImageEntity::class);
        $roomImageEntity->imgName = 'example';

        $imagesArray = [$roomImageEntity, $roomImageEntity];

        $roomImageGenerator = $this->createMock(App\Classes\Models\RoomImageGenerator::class);
        $roomImageGenerator->method('getImagesForRoomType')->willReturn($imagesArray);

        $logger = $this->createMock(\Monolog\Logger::class);
        $roomTypeController = new \App\Classes\Controllers\RoomTypeController($roomInfoGenerator, $roomImageGenerator, $logger);
        $output = $roomTypeController->getRoomTypes();

        $this->assertTrue(is_array($output['data']));

        foreach ($output['data'] as $roomType) {
            $this->assertEquals($roomType->id, $id);
            $this->assertEquals($roomType->name, $name);
            $this->assertEquals($roomType->hasCot, $hasCot);
            $this->assertEquals($roomType->minStay, $minStay);
            $this->assertEquals($roomType->numberInHotel, $numberInHotel);
            $this->assertEquals($roomType->description, $description);
            $this->assertTrue(is_array($roomType->imgNames));
            $this->assertEquals($roomType->imgNames, $imagesArray);
            $this->assertEquals($roomType->pricePerNight, $pricePerNight);
            $this->assertEquals($roomType->numberOfAdults, $numberOfAdults);
        }
    }

//    public function testGetRoomTypesFailure()
//    {
//        $roomInfoEntity = $this->createMock(App\Classes\Entities\RoomInfoEntity::class);
//        $roomInfoEntity->id = 2;
//        $roomInfoEntity->name = 'Bob';
//        $roomInfoEntity->pricePerNight = 12;
//        $roomInfoEntity->numberOfAdults = 13;
//        $roomInfoEntity->hasCot = 1;
//        $roomInfoEntity->minStay = 14;
//        $roomInfoEntity->numberInHotel = 15;
//        $roomInfoEntity->description = 'bla';
//
//        $roomInfoArray = [$roomInfoEntity, $roomInfoEntity];
//
//        $roomInfoGenerator = $this->createMock(App\Classes\Models\RoomInfoGenerator::class);
////        $roomInfoGenerator->method('getRoomsInfo')->willReturn([null]);
//
//        $roomImageEntity = $this->createMock(App\Classes\Entities\RoomImageEntity::class);
//        $roomImageEntity->imgName = '5.jpg';
//
//        $imagesArray = [$roomImageEntity, $roomImageEntity];
//
//        $roomImageGenerator = $this->createMock(App\Classes\Models\RoomImageGenerator::class);
////        $roomImageGenerator->method('getImagesForRoomType')->willReturn([null]);
//
//
//        $logger = $this->createMock(\Monolog\Logger::class);
//        $roomType = new \App\Classes\Controllers\RoomTypeController($roomInfoGenerator, $roomImageGenerator, $logger);
//        $output = $roomType->getRoomTypes();
//
//        foreach ($output as $roomtype) {
//            $this->assertTrue(true, array_key_exists('id', $output));
//            $this->assertTrue(true, array_key_exists('name', $output));
//            $this->assertTrue(true, array_key_exists('pricePerNight', $output));
//            $this->assertTrue(true, array_key_exists('numberOfAdults', $output));
//            $this->assertTrue(true, array_key_exists('hasCot', $output));
//            $this->assertTrue(true, array_key_exists('minStay', $output));
//            $this->assertTrue(true, array_key_exists('numberInHotel', $output));
//            $this->assertTrue(true, array_key_exists('description', $output));
//            $this->assertTrue(true, array_key_exists('imgName', $output));
//        }
//    }

}