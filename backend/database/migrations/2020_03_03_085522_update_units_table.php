<?php

use App\Entities\Unit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('domain')->default('funrun.com');
        });

        // Add correct domain to current units
        Unit::where('title', 'Reading')->update([
            'domain' => 'gobookpro.com'
        ]);
        Unit::where('title', 'Golden Rule')->update([
            'domain' => 'goldenrulerally.com'
        ]);
        Unit::where('title', 'Laps - Pro')->update([
            'domain' => 'funrunpro.com'
        ]);
        Unit::where('title', 'Events - Bash')->update([
            'domain' => 'theboosterbash.com'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('domain');
        });
    }
}
