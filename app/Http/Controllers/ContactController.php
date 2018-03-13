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

    public function insertPoll(Request $request){
        if($request->ajax()){
            $question = $request->get('poll');

            $res = Polls::insertPoll($question);

            if(!empty($res)){

                return response()->json([
                    'message' => 'success',
                    'id' => $res
                ]);
            }
        }
    }

    public function deletePoll(Request $request){
        if($request->ajax()){
            $polls = $request->get('selected');
            $res = Polls::deletePoll($polls);

            if($res > 0){
                return response('success');
            }
        }
    }

    public function insertAnswer(Request $request){
        if($request->ajax()){
            $question = $request->get('question');
            $answer = $request->get('answer');
            $id = Polls::insertNewAnswer($question, $answer);

            if(!empty($id)){
                return response()->json([
                    'message' => 'success',
                    'id' => $id
                ]);
            }
        }
    }

    public function deleteAnswers(Request $request){
        if($request->ajax()){
            $answers = $request->get('selected');
            $res = Polls::deleteAnswers($answers);

            if($res > 0){
                return response('success');
            }
        }
    }

}