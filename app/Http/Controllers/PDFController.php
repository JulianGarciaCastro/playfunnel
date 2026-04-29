<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use PDF;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateBillPDF(Request $request){
        $planID = $request->planid;
        
        $user = Auth::user();
        $plan = $user->getPlanSusbcription->where("id",$planID)->first();
        
        if ($plan){
            $data = [
                'title'     => $plan->getPlanName(),
                'size'      => $plan->getPlanSize(),
                'price'     => $plan->getPlanPrice(),
                'dateSubs'  => $plan->getPlanSubscriptionDate(),
                'date'      => date('m/d/Y')
            ];
            
            $pdf = PDF::loadView('billPDF', $data);
        }
        
        
    
        return $pdf->download('itsolutionstuff.pdf');
    }
}