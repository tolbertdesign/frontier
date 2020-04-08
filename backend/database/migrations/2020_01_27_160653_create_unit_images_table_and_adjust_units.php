<?php

use App\Entities\Unit;
use App\Entities\UnitImage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitImagesTableAndAdjustUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $unitImages = [
            ['id' => '1', 'image_file_base_name' => 'shoe', 'name' => 'Shoe'],
            ['id' => '2', 'image_file_base_name' => 'books', 'name' => 'Books'],
            ['id' => '3', 'image_file_base_name' => 'shaking_hands', 'name' => 'Shaking Hands'],
            ['id' => '4', 'image_file_base_name' => 'stretching', 'name' => 'Stretching'],
            ['id' => '5', 'image_file_base_name' => 'clock', 'name' => 'Clock'],
        ];
        Schema::create('unit_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_file_base_name');
            $table->string('name');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->integer('unit_image_id')->nullable()->default(null);
        });
        UnitImage::insert($unitImages);

        Unit::where('title', 'Laps')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Reading')
            ->update(['unit_image_id' => 2]);
        Unit::where('title', 'Golden Rule')
            ->update(['unit_image_id' => 3]);
        Unit::where('title', 'Fitness Challenge')
            ->update(['unit_image_id' => 4]);
        Unit::where('title', 'Obstacle')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Activity')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Event')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Dance Move')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Laps - Pro')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Events - Bash')
            ->update(['unit_image_id' => 1]);
        Unit::where('title', 'Minutes')
            ->update(['unit_image_id' => 5]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_images');
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'unit_image_id')) {
                $table->dropColumn('unit_image_id');
            }
        });
    }
}
