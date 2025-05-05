<?php

namespace App\Http\Services;

use App\Http\Repositories\ActDefenceRepository;
use App\Http\Repositories\DefenceParticipantRepository;
use App\Http\Repositories\DefenceRepository;
use App\Http\Repositories\StudentRepository;

class DefenceService
{
    private ActDefenceRepository $actDefenceRepository;
    private DefenceParticipantRepository $defenceParticipantRepository;
    private StudentRepository $studentRepository;
    public function __construct(
        ActDefenceRepository $actDefenceRepository,
        DefenceParticipantRepository $defenceParticipantRepository,
        StudentRepository $studentRepository
    )
    {
        $this->actDefenceRepository = $actDefenceRepository;
        $this->defenceParticipantRepository = $defenceParticipantRepository;
        $this->studentRepository = $studentRepository;
    }

    public function addTeams($teams, $defenceId)
    {
        foreach ($teams as $team) {
            if(!is_null($team) && !$this->actDefenceRepository->checkUnique($team, $defenceId)) {
                $this->actDefenceRepository->create($team, $defenceId);
            }
        }
    }
    public function addTeamParticipants($teamId, $participants){
        foreach ($participants as $participant) {
            if(!is_null($participant) && !$this->defenceParticipantRepository->checkUnique($teamId, $participant)) {
                $this->defenceParticipantRepository->create($teamId, $participant);
            }
        }
    }
    public function addPersonalDefence($participants, $defenceId){
        foreach ($participants as $participant) {
            $student = $this->studentRepository->get($participant);
            if(!is_null($participant) && !$this->actDefenceRepository->checkUnique('Личная защита ' . $student->getFullFio(), $defenceId)) {
                $actDefence = $this->actDefenceRepository->create('Личная защита ' . $student->getFullFio(), $defenceId);
                $this->addTeamParticipants($actDefence->id, $participants);
            }
        }
    }
}
