<?php

class Graphs{

    function __construct($model, $intialTrim, $finalTrim, $intialYear, $finalYear, $organization, $userCountries)
    {
        $this->model = $model;
        $this->intialTrim = $intialTrim;
        $this->finalTrim = $finalTrim;
        $this->intialYear = $intialYear;
        $this->finalYear = $finalYear;
        $this->organization = $organization;
        $this->userCountries = $userCountries;

    }

    /**
     * Gets the total of collaborators in risk and compares them to the grand total
     * @return array
     */
    public function getCollaboratorsInRisk(){
        $data = $this->model->groupGenericNumericValues($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
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
        $data = $this->model->groupByMorbility($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);

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
        $data = $this->model->getCollaboratorsUnderMedicalAttention($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = $data;

        return $response;

    }

    /**
     * Retrieves the compliance levels by organization
     * @return array
     */
    public function getComplianceLevels(){
        $data = $this->model->getComplianceLevelsByOrganization($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
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
        $data = $this->model->getLeadersAndCollaboratorsTraining($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
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
     * Retrieves the totals of the trainings by leaders and collaborators.
     * @return array
     */
    public function getLeadersAndCollaboratorsTrainingByCountry(){
        $data = $this->model->getLeadersAndCollaboratorsTrainingByCountry($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
        $countryData = array();


        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->pais, $countryData) == false){
                $countryData[$record->pais] = array();

            }

            array_push($countryData[$record->pais], array(
                "capacitacion_colaboradores_terminado" => $record->capacitacion_colaboradores_terminado,
                "capacitacion_lideres_terminado" => $record->capacitacion_lideres_terminado,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $countryData;


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getLeadersTrainingPercentage(){
        $data = $this->model->getLeadersTrainingPercentage($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);

        return $data;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getCollaboratorsTrainingPercentage(){
        $data = $this->model->getCollaboratorsTrainingPercentage($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);

        return $data;
    }


    /**
     * Retrieves the totals of
     * @return array
     */
    public function getSurveysData(){
        $data = $this->model->getSurveysData($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
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
     * Retrieves the totals of
     * @return array
     */
    public function getSurveysDataByCountry(){
        $data = $this->model->getSurveysDataByCountry($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
        $countryData = array();



        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->pais, $countryData) == false){
                $countryData[$record->pais] = array();

            }

            array_push($countryData[$record->pais], array(
                "healt_survey_totals" => $record->encuesta_salud,
                "energy_survey_totals" => $record->encuesta_gestion_energia,
                "wealth_survey_totals" => $record->encuesta_bienestar,
                "programs_survey_totals" => $record->encuesta_programas_empresa,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $countryData;

        return $response;

    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getAbsentsByOrganizationAndDate(){
        $data = $this->model->getAbsentsByOrganizationAndDate($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
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
    public function getAbsentsByCountryAndDate(){
        $data = $this->model->getAbsentsByCountryAndDate($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);
        $countriesData = array();


        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->pais, $countriesData) == false){
                $countriesData[$record->pais] = array();

            }

            array_push($countriesData[$record->pais], array(
                "total_absents" => $record->dias_ausentismo,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $countriesData;

        return $response;

    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function percentageAbsentsByType(){
        $data = $this->model->getPercentageByAbsentType($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);

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



    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getProgramsPerPilar(){
        $data = $this->model->getProgramsPerPilar($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "pilar" => $record->pilar,
                "total_programas" => $record->total_programas

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getProgramsPerOrganization(){
        $data = $this->model->getProgramsPerOrganization($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "organizacion" => $record->organizacion,
                "total_programas" => $record->total_programas

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getProgramsPerCategory(){
        $data = $this->model->getProgramsPerCategory($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "categoria" => $record->categoria,
                "total_programas" => $record->total_programas

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getParticipationsPerOrganization(){
        $data = $this->model->getParticipationsPerOrganization($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "organizacion" => $record->organizacion,
                "total_participaciones" => $record->total_participaciones

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getParticipationsPerPilar(){
        $data = $this->model->getParticipationsPerPilar($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "pilar" => $record->pilar,
                "total_participaciones" => $record->total_participaciones

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getParticipationsPerCategory(){
        $data = $this->model->getParticipationsPerCategory($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);


        $response = array();
        foreach($data as $record){


            array_push($response, array(
                "categoria" => $record->categoria,
                "total_participaciones" => $record->total_participaciones

            ));

        }


        return $response;
    }


    /**
     * Retrieves the percenatges of the trainings by leaders and collaborators.
     * @return array
     */
    public function getProgramsGeneralData(){
        $data = $this->model->getProgramsGeneralData($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, $this->organization, $this->userCountries);

        $response = array(
            "total_programas" => $data->total_programas,
            "total_participaciones" => $data->total_participaciones

        );



        return $response;
    }
}