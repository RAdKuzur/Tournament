<?php

namespace App\Http\Repositories;

use App\Models\DefenceParticipant;

class DefenceParticipantRepository
{
    public function getParticipants($actDefenceId)
    {
        return DefenceParticipant::where('act_defence_id', $actDefenceId)->get();
    }
    public function getByActDefences($acts)
    {
        return collect($acts)->flatMap(function ($act) {
            return $this->getParticipants($act->id);
        });
    }
    public function checkUnique($actDefenceId, $participantId)
    {
        return DefenceParticipant::where('act_defence_id', $actDefenceId)->where('student_id', $participantId)->exists();
    }
    public function create($actDefenceId, $participantId){
        $defenceParticipant = DefenceParticipant::create([
            'act_defence_id' => $actDefenceId,
            'student_id' => $participantId,
            'score' => 0
        ]);
        return $defenceParticipant->id;
    }
    public function get($id)
    {
        return DefenceParticipant::find($id);
    }
    public function delete($id){
        return DefenceParticipant::destroy($id);
    }
    public function changeScore($participant, $type, $score)
    {
        switch ($type) {
            case DefenceParticipant::PLUS:
                $participant->score = $participant->score + $score;
                return $participant->save();
            case DefenceParticipant::MINUS:
                $participant->score = $participant->score - $score;
                return $participant->save();
            default:
                return null;
        }
    }
}
