<?php

use Illuminate\Database\Seeder;
use App\Entities\ProgramTodo;
use App\Entities\Program;

class ProgramTodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labelList = ProgramTodo::getLabelList();
        $programs  = Program::all();

        $programs->each(function ($program) use ($labelList) {
            $programTodos = [];
            foreach ($labelList as $label) {
                $programTodos[] = [
                    'program_id' => $program->id,
                    'todo_label' => $label,
                ];
            }
            ProgramTodo::insert($programTodos);
        });
    }
}
