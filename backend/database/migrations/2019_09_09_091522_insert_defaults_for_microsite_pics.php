<?php

use App\Entities\MicrositePic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultsForMicrositePics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('microsite_pics', function (Blueprint $table) {
            $table->boolean('is_searchable')->default(false);
        });

        MicrositePic::insert([
            [
                'image'         => '160927941_art_program.jpeg',
                'description'   => 'art',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_art_program2.jpeg',
                'description'   => 'art',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_budget.jpeg',
                'description'   => 'budget, funds',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_cafeteria.jpeg',
                'description'   => 'cafeteria',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_classroom_resources.jpeg',
                'description'   => 'classroom, resources',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_classroom_resources2.jpeg',
                'description'   => 'classroom, resources',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_classroom_supplies.jpeg',
                'description'   => 'classroom, supplies',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_classroom_supplies2.jpeg',
                'description'   => 'classroom, supplies',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_computer_lab.jpeg',
                'description'   => 'computer, labs',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_equipment.jpeg',
                'description'   => 'equipment, av',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_equipment2.jpeg',
                'description'   => 'equipment, av',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_equipment3.jpeg',
                'description'   => 'equipment, av',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_facilities.jpeg',
                'description'   => 'facilities',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_facilities2.jpeg',
                'description'   => 'facilities',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_field_trips.jpeg',
                'description'   => 'field trip',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_field_trips2.jpeg',
                'description'   => 'field trip',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_ipads.jpeg',
                'description'   => 'ipads, technology, tablets',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_library.jpeg',
                'description'   => 'library, books',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_library2.jpeg',
                'description'   => 'library, books',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_lockers.jpeg',
                'description'   => 'lockers',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_morning_announcement.jpeg',
                'description'   => 'equipment, av',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_playground.jpeg',
                'description'   => 'playground',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_playground2.jpeg',
                'description'   => 'playground',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_school_budget.jpeg',
                'description'   => 'budget, funds',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_school_needs.jpeg',
                'description'   => 'budget, funds',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_science_lab.jpeg',
                'description'   => 'science, lab',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_smartboard.jpeg',
                'description'   => 'smartboard, technology',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_smartboard2.jpeg',
                'description'   => 'smartboard, technology',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_stem.jpeg',
                'description'   => 'stem',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_tablets.jpeg',
                'description'   => 'tablets, technology',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_teacher.jpeg',
                'description'   => 'teacher',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_teacher2.jpeg',
                'description'   => 'teacher',
                'is_searchable' => true
            ],
            [
                'image'         => '160927941_technology.jpeg',
                'description'   => 'technology, computers',
                'is_searchable' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('microsite_pics', function (Blueprint $table) {
            $table->dropColumn('is_searchable');
        });

        MicrositePic::whereIn('image', [
            '160927941_art_program.jpeg',
            '160927941_art_program2.jpeg',
            '160927941_budget.jpeg',
            '160927941_cafeteria.jpeg',
            '160927941_classroom_resources.jpeg',
            '160927941_classroom_resources2.jpeg',
            '160927941_classroom_supplies.jpeg',
            '160927941_classroom_supplies2.jpeg',
            '160927941_computer_lab.jpeg',
            '160927941_equipment.jpeg',
            '160927941_equipment2.jpeg',
            '160927941_equipment3.jpeg',
            '160927941_facilities.jpeg',
            '160927941_facilities2.jpeg',
            '160927941_field_trips.jpeg',
            '160927941_field_trips2.jpeg',
            '160927941_ipads.jpeg',
            '160927941_library.jpeg',
            '160927941_library2.jpeg',
            '160927941_lockers.jpeg',
            '160927941_morning_announcement.jpeg',
            '160927941_playground.jpeg',
            '160927941_playground2.jpeg',
            '160927941_school_budget.jpeg',
            '160927941_school_needs.jpeg',
            '160927941_science_lab.jpeg',
            '160927941_smartboard.jpeg',
            '160927941_smartboard2.jpeg',
            '160927941_stem.jpeg',
            '160927941_tablets.jpeg',
            '160927941_teacher.jpeg',
            '160927941_teacher2.jpeg',
            '160927941_technology.jpeg'
        ])->delete();
    }
}
