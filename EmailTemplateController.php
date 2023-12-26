<?php

namespace App\Http\Controllers\Api;

use auth;
use Mail;
use App\Models\lead;
use App\Mail\MyTestMail;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use App\Services\EmailTemplateService;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends Controller
{
    public $emailtemplateService;
    public function __construct()
    {
        $this->emailtemplateService = new EmailTemplateService();
    }
    // public function index()
    // {
      // dd($emailtemp);
    //     $data = Lead::all();
    //     $userId = auth::user()->id;
    //     $leadDetails = Lead::all()->get('id');
    //     $emailtemp = EmailTemplate::all();
    //    dd($leadDetails);
       
        // template id 
        // you can find email_template table all details  like titile ,subject, blade filename
        // also get lead id from any process update create
        // find leaddetails get name ,email other things

        // email send to -
        // $mailData = [
        //     'title' => 'Mail from ItSolutionStuff.com',

        //     'body' => 'This is for testing email using smtp.'
        // ];
         
        // Mail::to('pravinkadam234@gmail.com')->send(new MyTestMail($mailData));
           
        // dd("Email is sent successfully.");
   // }

   public function index(Request $request)
   {
       $input = $request->all();
       $count = $this->emailtemplateService->getAllEmailTemplate($input);
       $data = $this->emailtemplateService->getAllEmailTemplateList($input);

       return response()->json([
           'status' => true,
           'message' => 'Email template List',
           'total_count' => $count,
           'Data' => $data,
       ],200);
     
   }
    
    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email_template_type_id'=> 'required',
                    'subject_name'=>'required',
                    'email_template_title_id'=> 'required',
                    'message' => 'required',
                    'status' => 'required',
                ]
            );


            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $input = $request->all();
            
            $existingTemplate = EmailTemplate::where('email_template_type_id', $input['email_template_type_id'])
                            ->where('email_template_title_id', $input['email_template_title_id'])->first();

            if ($existingTemplate) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Template is already exists',
                ], 400);
            }

            $result = $this->emailtemplateService->saveEmailTemplate($input);
            if ($result['status']) {
                return response()->json([
                    'status' => true,
                    'message' => $result['message'],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $result['message'],
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $EmailTemplate = $this->emailtemplateService->getEmailTemplateRecord($id);
        if ($EmailTemplate) {
            return response()->json([
                'status' => true,
                'message' => 'Find record',
                'response' => $EmailTemplate,
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
                'response' => $EmailTemplate,
            ],404);
        }
    }

    public function update(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'email_template_type_id'=> 'required',
                    'subject_name'=>'required',
                    'email_template_title_id'=> 'required',
                    'message' => 'required',
                    'status' => 'required',
                ]
                
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $input = $request->all();
            $EmailTemplate = $this->emailtemplateService->getEmailTemplateRecord($input['id']);

            if ($EmailTemplate) {
                $result = $this->emailtemplateService->updateEmailTemplate($input);
                if ($result['status']) {
                    return response()->json([
                        'status' => true,
                        'message' => $result['message'],
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => $result['message'],
                    ], 500);
                }

            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record not found',
                    'response' => $EmailTemplate,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {   
        $checkRecord = $this->emailtemplateService->getEmailTemplateRecord($id);
        if ($checkRecord) {
            $response = $this->emailtemplateService->deleteRecord($id);
            if($response['status']){
                return response()->json([
                    'status' => true,
                    'message' => $response['message'],
               
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => $response['message'],
               
                ],404);
            }
           
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ],404);
        }  
    }

    public function emailtemplatetitle(Request $request)
    {
        $emailTemplateTitleList = $this->emailtemplateService->emailTemplateTitleList();
        return response()->json([
            'status' => 'true',
            'message' => 'Email Template Title List',
            'data'=> $emailTemplateTitleList
        ]);
    }

    public function emailtemplatetype(Request $request)
    {
        $emailTemplateTypeList = $this->emailtemplateService->emailTemplateTypeList();
        return response()->json([
            'status' => 'true',
            'message' => 'Email Template Type List',
            'data'=> $emailTemplateTypeList
        ]);
    }
}

