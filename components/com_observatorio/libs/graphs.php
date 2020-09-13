<?php

class Graphs{

    function __construct($model, $intialTrim, $finalTrim, $intialYear, $finalYear, $organization)
    {
        $this->model = $model;
        $this->intialTrim = $intialTrim;
        $this->finalTrim = $finalTrim;
        $this->intialYear = $intialYear;
        $this->finalYear = $finalYear;
        $this->organization = $organization;

    }

    /**
     * Gets the total of collaborators in risk and compares them to the grand total
     * @return array
     */
    public function getCollaboratorsInRisk(){
        $data = $this->model->groupGenericNumericValues($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);
        $response = array(
            "total" => $data->total,
            "total_risk" => $data->total_risk,
            "percentage_risk" => ($data->total > 0 ) ? ($data->total_risk * 100) / $data->total : 0
        );
        return $response;

    }


    /**
     * Gets the total of cases grouped by "Morbilidad".
     * @return array
     */
    public function getTotalsByMorbidity(){
        $data = $this->model->groupByMorbility($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);

        $total = 0;
        $morbidities = array();
        foreach ($data as $morbidityRow){
            foreach ($morbidityRow as $morbidity){
                if(in_array($morbidity->morbilidad_alias, $morbidities)){
                    $morbidities[$morbidity->morbilidad_alias] += $morbidity->morbilidad_total;

                }else{
                    $morbidities[$morbidity->morbilidad_alias] = $morbidity->morbilidad_total;

                }

                $total += $morbidity->morbilidad_total;
            }
        }

        $data = array();
        foreach ($morbidities as $key=>$value){
            array_push($data, array(
                "morbidity_alias" => $key,
                "morbidity_total" => $value
            ));
        }

        $response = array(
            "total" => $total,
            "morbidities" => $data
        );

        return $response;

    }


    /**
     * Retrieves the total number of collaborators under medical attention
     * @return array
     */
    public function getCollaboratorsUnderMedicalAttention(){
        $data = $this->model->getCollaboratorsUnderMedicalAttention($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);


        $response = $data;

        return $response;

    }

    /**
     * Retrieves the compliance levels by organization
     * @return array
     */
    public function getComplianceLevels(){
        $data = $this->model->getComplianceLevelsByOrganization($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);
        $organizationsData = array();

        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->organizacion, $organizationsData) == false){
                $organizationsData[$record->organizacion] = array();

            }

            array_push($organizationsData[$record->organizacion], array(
                "nivel_cumplimiento" => $record->nivel_cumplimiento,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $organizationsData;

        return $response;
    }


    /**
     * Retrieves the totals of the trainings by leaders and collaborators.
     * @return array
     */
    public function getLeadersAndCollaboratorsTraining(){
        $data = $this->model->getLeadersAndCollaboratorsTraining($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);
        $organizationsData = array();

        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->organizacion, $organizationsData) == false){
                $organizationsData[$record->organizacion] = array();

            }

            array_push($organizationsData[$record->organizacion], array(
                "capacitacion_colaboradores_terminado" => $record->capacitacion_colaboradores_terminado,
                "capacitacion_lideres_terminado" => $record->capacitacion_lideres_terminado,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $organizationsData;

        return $response;
    }

    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getLeadersTrainingPercentage(){
        $data = $this->model->getLeadersTrainingPercentage($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);

        return $data;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getCollaboratorsTrainingPercentage(){
        $data = $this->model->getCollaboratorsTrainingPercentage($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);

        return $data;
    }


    /**
     * Retrieves the totals of
     * @return array
     */
    public function getSurveysData(){
        $data = $this->model->getSurveysData($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);
        $organizationsData = array();


        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->organizacion, $organizationsData) == false){
                $organizationsData[$record->organizacion] = array();

            }

            array_push($organizationsData[$record->organizacion], array(
                "healt_survey_totals" => $record->encuesta_salud,
                "energy_survey_totals" => $record->encuesta_gestion_energia,
                "wealth_survey_totals" => $record->encuesta_bienestar,
                "programs_survey_totals" => $record->encuesta_programas_empresa,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $organizationsData;

        return $response;

    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getAbsentsByOrganizationAndDate(){
        $data = $this->model->getAbsentsByOrganizationAndDate($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);
        $organizationsData = array();


        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->organizacion, $organizationsData) == false){
                $organizationsData[$record->organizacion] = array();

            }

            array_push($organizationsData[$record->organizacion], array(
               "total_absents" => $record->dias_ausentismo,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $organizationsData;

        return $response;

    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function percentageAbsentsByType(){
        $data = $this->model->getPercentageByAbsentType($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization);

        $total = $data->type_general + $data->type_preventable + $data->type_mental;

        $response = array(
            "total" => $total,
            "percentage_general" => ($total > 0 ) ? ($data->type_general * 100) / $total : 0,
            "percentage_preventable" => ($total > 0 ) ? ($data->type_preventable * 100) / $total : 0,
            "percentage_mental" => ($total > 0 ) ? ($data->type_mental * 100) / $total : 0,
            "total_general" => $data->type_general,
            "total_preventable" => $data->type_preventable,
            "total_mental" => $data->type_mental,
        );
        return $response;
    }
}