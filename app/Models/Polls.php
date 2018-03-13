<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 13.3.18.
 * Time: 10.56
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Polls
{
    public function __construct()
    {
    }

    public static function getAllQuestions(){

        if(!session()->has('user'))
            return null;

        $res = DB::table("Poll_question")
            ->whereNotIn('id', function ($query){
                $query->select('question_id')
                    ->from('Poll_votes')
                    ->where('user_id', '=', session()->get('user')[0]->id);
            })
            ->get();
        return $res;
    }

    public static function getAll(){
        $res = DB::table("Poll_question")
            ->get();
        return $res;
    }

    public static function getAnswers($id){
        $res = DB::table("Poll_answer")
            ->where('question_id', '=', $id)
            ->get();
        return $res;
    }

    public static function insertVote($question, $answer){
        $res = DB::table('Poll_votes')
            ->insertGetId([
                'question_id' => $question,
                'answer_id' => $answer,
                'user_id' => session()->get('user')[0]->id
            ]);
        return $res;
    }

    public static function getResult($question){
        $res = DB::table('Poll_answer')
            ->join('Poll_votes', 'Poll_answer.id', '=', 'Poll_votes.answer_id')
            ->select('Poll_answer.answer', (DB::raw('COUNT(Poll_votes.answer_id) as res')))
            ->where('Poll_votes.question_id', '=', $question)
            ->groupBy('Poll_answer.id')
            ->get();
        return $res;
    }

    public static function insertPoll($question){
        $id = DB::table("Poll_question")
            ->insertGetId([
                'question' => $question
            ]);
        return $id;
    }

    public static function deletePoll($polls){
        $a = DB::table('Poll_answer')
            ->whereIn('question_id', $polls)
            ->delete();

        $res = DB::table('Poll_question')
            ->whereIn('id', $polls)
            ->delete();
        return $res;
    }

    public static function insertNewAnswer($question, $answer){
        $id = DB::table("Poll_answer")
            ->insertGetId(
                [
                    'question_id' => $question,
                    'answer' => $answer
                ]
            );
        return $id;
    }

    public static function deleteAnswers($answers){
        $a = DB::table('Poll_answer')
            ->whereIn('id', $answers)
            ->delete();

        return $a;
    }
}