<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 13.3.18.
 * Time: 10.20
 */

namespace App\Http\Controllers;


use App\Models\Polls;
use Illuminate\Http\Request;

class ContactController
{
    public function __construct()
    {
    }

    public function render(){
        $questions = Polls::getAllQuestions();
        //dd(Polls::getResult(1));

        return view('pages.contact', ['questions' => $questions]);
    }

    public function getAnswers(Request $request){
        if($request->ajax()){
            $id = $request->get('id');
            $answers = Polls::getAnswers($id);

            if(!empty($answers)){
                return response()->json([
                    'message' => 'success',
                    'answers' => $answers
                ]);
            }
        }
    }

    public function insertVote(Request $request){
        if($request->ajax()){
            $question = $request->get('question');
            $answer = $request->get('answ');

            $res = Polls::insertVote($question, $answer);

            if(!empty($res)){

                $result = Polls::getResult($question);

                return response()->json([
                    'message' => 'success',
                    'results' => $result
                ]);
            }
        }
    }
}