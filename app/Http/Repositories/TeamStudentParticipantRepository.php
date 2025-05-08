<?php

namespace App\Http\Repositories;

use App\Models\TeamStudentParticipant;

class TeamStudentParticipantRepository
{
    public function get($id)
    {
        return TeamStudentParticipant::find($id);
    }
    public function changeScore($id, $type, $score, $gameId){
        $teamStudentParticipant = $this->getParticipant($id, $gameId);
        if($type == TeamStudentParticipant::PLUS){
            $teamStudentParticipant->score = $teamStudentParticipant->score + $score;
        }
        else {
            $teamStudentParticipant->score = $teamStudentParticipant->score - $score;
        }
        $teamStudentParticipant->save();
    }
    public function getParticipant($teamStudentId, $gameId){
        return TeamStudentParticipant::where('team_student_id', $teamStudentId)->where('game_id', $gameId)->first();
    }
    public function createParticipants($participants, $gameId){
        foreach($participants as $participant){
            TeamStudentParticipant::create(
                [
                    'team_student_id' => $participant->id,
                    'game_id' => $gameId,
                    'score' => 0,
                ]
            );
        }

    }

}
