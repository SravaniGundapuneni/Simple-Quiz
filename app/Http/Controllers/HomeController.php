<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(QuizController $quiz)
	{
		$quizes = $quiz->getQuizes();
		return view('home')->with(['quizes' => $quizes]);
	}
}
