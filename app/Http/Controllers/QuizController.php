<?php

namespace App\Http\Controllers;

use App\Mark;
use App\Method;
use App\Question;
use App\Quiz;
use App\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * @return Response
     */
    public function getQuizes()
    {
        $quizzes = Quiz::all();

        return $quizzes;
    }

    /**
     * @param $quizId
     * @return View
     */
    public function getQuiz($quizId)
    {
       $quiz = Quiz::find($quizId);

       $question_ids = \DB::table('questions')->select('id')->where('quiz_id','=',$quizId)->get();
	    foreach($question_ids as $question){
		$options[$this->getQuestionName($question->id)][] = $this->getQuestion($question->id);
	    }

        return view('quiz')->with(['questions' => $options,'quiz' => $quiz]);
     }

    /**
     * @param $questionId
     * @return questionname
     */
 
    public function getQuestionName($questionId)
    {
	$question = Question::find($questionId);
	return $question->name;
    }
        
    /**
     * @param $questionId
     * @return questionoptions
     */
    public function getQuestion($questionId)
    {
	$question = Question::with('responses')->where('id', $questionId)->firstOrFail();
	return $question;
    }

    /**
     * @param Request $request
     * @return Responses
     */
    public function getResult(Request $req)
    {
       
        $input = $req->all();
		if(isset($input['option'])){
			$array_of_options = $input['option'];
			foreach($array_of_options as $key => $value){
				//$key = question id
				//$value = user submitted answer
				$answer = Response::select('id')
                                        ->where('question_id','=',$key)
                                        ->where('value', '=', 1)
                                        ->get();
                       
				if(count($answer) === 1){
					//Single answer
					$answer = $answer->first();
                                      
					if($answer->id == $value){
						//User answer is correct
						$correct_answer[$key] = $value;
                                               
					}else{
						//User answer isn't correct
						$wrong_answer[$key] = $value;
					}
                                        
				}else{
					//Multiple answer
					foreach($answer as $ans){
						foreach ($value as $val) {
							if($ans->option_id === $val){
								$multiple_right_answer[] = $val;
							}
						}
					}
					if(isset($multiple_right_answer)){
						if(count($multiple_right_answer) === count($answer)){
							$correct_answer[$key] = $value;
						}else{
							$wrong_answer[$key] = $value;
						}
					}else{
						$wrong_answer[$key] = $value;
					}
				}//End of Multiple answer
				$multiple_right_answer = null;
			
			}
			if(isset($correct_answer)){
				$correct_answer_count = count($correct_answer);
				//Get the skill result
				$correct_answer_array = array_keys($correct_answer);
			
			}else{
				$correct_answer_count = 0;
				$correct_answer = null;
			}
			if(isset($wrong_answer)){
				$wrong_answer_count = count($wrong_answer);
			}else {
				$wrong_answer_count = 0;
				$wrong_answer = null;
			}
                       
			$success_percentage = ($correct_answer_count * 100)/($correct_answer_count + $wrong_answer_count);
			$result_data = [
				'user_id' => \Auth::user()->id,
				'quiz_id' => $req->input('quiz_id'),
				'total_attempt' => ($correct_answer_count + $wrong_answer_count),
				'value' => $correct_answer_count,
				'percentage' => $success_percentage
			];
			\DB::table('marks')->insert($result_data);
			$user_given_inputs = $input['option'];
			
			return view('result')->with(['user_given_inputs' => $user_given_inputs,'percentage' => $success_percentage,'correct_answer' => $correct_answer,'wrong_answer' => $wrong_answer]);
		}else{
			return view('result')->with(['message' => 'You did not answer any question. Try again!']);
                  
		}
        
    }

}
