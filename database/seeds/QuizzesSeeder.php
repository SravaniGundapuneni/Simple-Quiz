<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizzesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $this->createMathQuiz();
        });
        DB::transaction(function () {
            $this->createSciQuiz();
        });
        
    }

    protected function createMathQuiz()
    {
        $quiz = App\Quiz::create(['name' => 'Mathematics']);
      
        $question = App\Question::create([
            'name' => '20 % of 2 is equal to ?',
            'quiz_id' => $quiz->id,
        ]);
        App\Response::create(['name' => '0.4', 'value' => 1, 'question_id' => $question->id]);
        App\Response::create(['name' => '0.04', 'value' => 0, 'question_id' => $question->id]);
        App\Response::create(['name' => '4', 'value' => 0, 'question_id' => $question->id]);


        $question = App\Question::create([
            'name' => 'What percent of 60 is 54?',
            'quiz_id' => $quiz->id,
        ]);
        App\Response::create(['name' => '60 %', 'value' => 0, 'question_id' => $question->id]);
        App\Response::create(['name' => '90 %', 'value' => 1, 'question_id' => $question->id]);
        App\Response::create(['name' => '95 %', 'value' => 0, 'question_id' => $question->id]);
    }

    protected function createSciQuiz()
    {
        $quiz = App\Quiz::create(['name' => 'Science']);
    
        $question = App\Question::create([
            'name' => 'Which is the most abundant gas in the earths atmosphere?',
            'quiz_id' => $quiz->id
        ]);
        App\Response::create(['name' => 'Nitrogen', 'value' => 1, 'question_id' => $question->id]);
        App\Response::create(['name' => 'Oxygen', 'value' => 0, 'question_id' => $question->id]);
        App\Response::create(['name' => 'Carbon', 'value' => 0, 'question_id' => $question->id]);

        $question = App\Question::create([
            'name' => 'Which toxic element present in automobile exhausts?',
            'quiz_id' => $quiz->id
        ]);
        App\Response::create(['name' => 'Lead', 'value' => 1, 'question_id' => $question->id]);
        App\Response::create(['name' => 'CO2', 'value' => 0, 'question_id' => $question->id]);
        App\Response::create(['name' => 'CO', 'value' => 0, 'question_id' => $question->id]);
    }

}
