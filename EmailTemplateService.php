<?php

namespace App\Services;

use Exception;
use App\Models\EmailTemplate;
use App\Services\CommonService;
use App\Models\EmailTemplateType;
use App\Models\EmailTemplateTitle;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class EmailTemplateService
{

	public $emailTemplateTitle;
	public $emailTemplateType;
	public function __construct()
	{
		$this->emailTemplateTitle = new EmailTemplateTitle();
		$this->emailTemplateType = new EmailTemplateType();
	}

    public function getAllEmailTemplate($input)
	{
		$query = EmailTemplate::select('email_templates.id');

        if (isset($input['email_template_type_id']) && !empty($input['email_template_type_id'])) 
        {
            $query->where('email_template_type_id', $input['email_template_type_id']);
        }
        $count = $query->count();
        return $count;
		
	}

    public function getAllEmailTemplateList($input)
    {
        $noOfRecord = (isset($input['per_page_row']) && !empty($input['per_page_row'])) ? $input['per_page_row'] : 0;
		$page = (isset($input['page']) && !empty($input['page'])) ? $input['page'] : 0;

		if (!empty($page)) {
			$offset = $noOfRecord * ($page - 1);
		}

        $query = EmailTemplate::select('id','email_template_type_id','subject_name','email_template_title_id','message','status');
        
        if(isset($input['email_template_type_id']) && !empty($input['email_template_type_id']))
        {
            $query->where('email_template_type_id',$input['email_template_type_id']);
        }

        $query->whereNull('email_templates.deleted_at');

		if ($noOfRecord) {
			$query->limit($noOfRecord)->offset($offset);
		}

		$response = $query->get();
		return $response;
    }

    public function saveEmailTemplate($input)
	{
		try {
			
				$emailtemplateObj = new EmailTemplate();
				$emailtemplateObj->email_template_type_id = $input['email_template_type_id'];
				$emailtemplateObj->subject_name = $input['subject_name'];
				$emailtemplateObj->email_template_title_id =  $input['email_template_title_id'];
                $emailtemplateObj->message =  $input['message'];
                $emailtemplateObj->status =  $input['status'];
				$response = $emailtemplateObj->save();
		
			if ($response) {
				return [
					'status' => true,
					'message' => 'Email template added successfully',
					'data' => $response,
				];
			} else {
				return [
					'status' => false,
					'message' => 'Unable to added record',
					'data' => null,
				];
			}
		}catch(Exception $e) {
			return [
				'status' => false,
				'message' => $e->getMessage(),
				'data' => null,
			];
		}
    }

    public function getEmailTemplateRecord($id)
	{
		$record = EmailTemplate::find($id);
		return $record;
	}

    public function updateEmailTemplate($input)
	{
		try {
			    $emailtemplateObj = new EmailTemplate();
                $emailtemplateObj->exists = true;
                $emailtemplateObj->id = $input['id'];
				$emailtemplateObj->email_template_type_id = $input['email_template_type_id'];
				$emailtemplateObj->subject_name = $input['subject_name'];
				$emailtemplateObj->email_template_title_id =  $input['email_template_title_id'];
                $emailtemplateObj->message =  $input['message'];
                $emailtemplateObj->status =  $input['status'];
                $response = $emailtemplateObj->save();

			if ($response) {
				return [
					'status' => true,
					'message' => 'Email template update successfully',
					'data' => $response,
				];
			} else {
				return [
					'status' => false,
					'message' => 'Unable to update record',
					'data' => null,
				];
			}
		} catch (Exception $e) {
			return [
				'status' => false,
				'message' => $e->getMessage(),
				'data' => null,
			];
		}
	}

    public function deleteRecord($id){
		try{
			$deleteResponse = EmailTemplate::where('id', $id)->delete();
			if($deleteResponse){
				return [
					'status' => true,
					'message' => 'Record deleted successfully',
				];
			}else{
				return [
					'status' => false,
					'message' => 'Something went wrong',
				];
			}
		}
		catch (Exception $e) {
			return [
				'status' => false,
				'message' => $e->getMessage(),
			];
		}
	}

	public function emailTemplateTitleList(){
        return $this->emailTemplateTitle->emailtemplatetitleList();
    }

	public function emailTemplateTypeList(){
        return $this->emailTemplateType->emailtemplatetypeList();
    }
	
}