<?php


namespace App\Http\Requests\App;



class TaskRequest extends AppRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	return [];
        //return $this->initRules(new Task());
    }

}
