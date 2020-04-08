<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\MicrositeColorTheme;

class MakePkForColorThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove old primary constraint & rename it to hex_code
        Schema::table('microsite_color_themes', function (Blueprint $table) {
            $table->dropPrimary();
        });

        DB::statement('ALTER TABLE `microsite_color_themes` CHANGE `id` `hex_code` VARCHAR(7)');

        // Create new primary key
        Schema::table('microsite_color_themes', function (Blueprint $table) {
            $table->increments('id');
        });

        // Map old foreign key values to new ids.
        // If a color doesn't map to 1 of our supported colors, fallback to the color of our default_theme
        DB::statement('UPDATE `microsites`
            LEFT JOIN `microsite_color_themes` as `theme` on `theme`.`hex_code` = `microsites`.`color_theme_id`
            INNER JOIN `microsite_color_themes` as `default_theme`
            on `default_theme`.`theme_name` = \''.MicrositeColorTheme::DEFAULT_THEME.'\'
            SET `microsites`.`color_theme_id` = COALESCE(`theme`.`id`, `default_theme`.`id`)');

        // Convert foreign key to correct data type
        DB::statement('ALTER TABLE `microsites` MODIFY COLUMN `color_theme_id` INT(10) DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert data type
        DB::statement('ALTER TABLE `microsites` MODIFY COLUMN `color_theme_id` VARCHAR(7) DEFAULT NULL');

        // Revert mappings
        DB::statement('UPDATE `microsites`
            INNER JOIN `microsite_color_themes` as `theme` on `theme`.`id` = `microsites`.`color_theme_id`
            SET `microsites`.`color_theme_id` = `theme`.`hex_code`');

        Schema::table('microsite_color_themes', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        DB::statement('ALTER TABLE `microsite_color_themes` CHANGE `hex_code` `id` VARCHAR(7)');

        Schema::table('microsite_color_themes', function (Blueprint $table) {
            // Make old hex_code the primary key
            $table->primary('id');
        });
    }
}
