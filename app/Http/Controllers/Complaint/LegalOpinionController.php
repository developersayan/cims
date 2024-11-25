<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\AdditionalInformationEvaluation;
class LegalOpinionController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = CompalintEveOffence::where('com_sub_decision','LO')->get();
        return view('legal_opinion.index',$data);
    }

    public function view($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$data['offence_details']->complaint_id)->where('status','A')->get();
        return view('legal_opinion.view',$data);
    }
}
