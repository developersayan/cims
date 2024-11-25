<?php

namespace App\Http\Controllers\Complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint\CompalintEveOffence;
use App\Models\Complaint\complaintRegistrationModel;
use App\Models\Complaint\InformationEnrichmentTeam;
use App\Models\AdditionalInformationEvaluation;
use App\Models\User;
use Redirect;
use Session;
use Alert;
class InformationEnrichmentController extends Controller
{
    public function index()
    {
        $data = [];
        $data['data'] = CompalintEveOffence::where('com_sub_decision','IE')->get();
        return view('information_enrichment.index',$data);
    }

    public function view($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['information'] = AdditionalInformationEvaluation::where('complaint_id',$data['offence_details']->complaint_id)->where('status','A')->get();
        return view('information_enrichment.view',$data);
    }


    public function assginMember($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['offence_details'] = CompalintEveOffence::where('id',$id)->first();

        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        $data['data'] = InformationEnrichmentTeam::where('ir_id',$id)->get();
        $data['users'] = User::get();
        return view('information_enrichment.assign',$data);
    }

    public function assginMemberInsert(Request $request)
    {
        $new = new InformationEnrichmentTeam;
        $new->user_id = $request->user_id;
        $new->role = $request->role;
        $new->ir_id = $request->ir_id;
        $new->save();
        Alert::success('You\'ve Successfully Added A Member');
        return Redirect::back();
    }

    public function getList()
    {
        $data =[];
        $data['data'] = InformationEnrichmentTeam::where('user_id',auth()->user()->id)->whereIn('coi_status',['AA','N'])->get();
        return view('information_enrichment.index_dashboard',$data);
    }

    public function coiStatus($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['details'] = InformationEnrichmentTeam::where('id',$id)->first();
        $data['offence_details'] = CompalintEveOffence::where('id',$data['details']->ir_id)->first();
        $data['complaint'] = complaintRegistrationModel::where('complaintID',$data['offence_details']->complaint_id)->first();
        return view('information_enrichment.coi',$data);
    }

    public function coiStatusUpdate(Request $request)
    {
        $upd = [];
        $upd['coi_status'] = $request->coi_status;
        $upd['coi_description'] = $request->coi_description;
        InformationEnrichmentTeam::where('id',$request->id)->update($upd);
        Alert::success('Decision updated successfully');
        return redirect()->route('information.enrichment.get.list.assigned');
    }
}
