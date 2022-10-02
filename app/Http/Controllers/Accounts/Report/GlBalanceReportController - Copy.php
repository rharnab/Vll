<?php

namespace App\Http\Controllers\Accounts\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlBalanceReportController extends Controller
{
    /**
    * This Function return all gl-balance Sheet
    *
    */
    public function glBalanceSheet(Request $request){
        
        $frm_dt = date('Y-m-d', strtotime($request->frm_date));
        $to_dt = date('Y-m-d', strtotime($request->to_date));
        
        $assets_gl_list             = $this->getAssetsGlBalance();
        $liability_gl_list          = $this->getLiabilityGlBalance();
        $total_asset_gl_balance     = $this->sumChildBalance($assets_gl_list['root_gl']);
        $total_liability_gl_balance = $this->sumChildBalance($liability_gl_list['root_gl']);
        $data                       = [
            "assets_gl_list"             => $assets_gl_list,
            "liability_gl_list"          => $liability_gl_list,
            "total_asset_gl_balance"     => $total_asset_gl_balance,
            "total_liability_gl_balance" => $total_liability_gl_balance
        ];
        return view('gl.accounts.report.glbalance.details', $data);   
    }



    /**
    * This function return gl mother gl
    *
    */
    public function getMotherGl($account_no){
        $mother_gl = DB::table('gl_accounts')->select('mother_ac_no')->where('acc_no', $account_no)->first();
        return $mother_gl->mother_ac_no;
    }


    /**
    * This function return assets gl list array
    *
    */
    public function getAssetsGlBalance(){
        $asset_gl_list_array = [];

        // level 1 gl
        $asset_root_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no'])->where('gl_level', 1)->where('asset_liability_status', 0)->get();
        foreach($asset_root_gls as $asset_root_gl){
            $asset_gl_list_array['root_gl'][$asset_root_gl->acc_no] = [
                "account_name"    => $asset_root_gl->acc_name,
                "account_no"      => $asset_root_gl->acc_no,
                "balance"         => $this->accountBalanceSummation($asset_root_gl->acc_no),
                "second_level_gl" => []
            ];
        }

        // level 2 gl
        $asset_2nd_level_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no', 'mother_ac_no'])->where('gl_level', 2)->where('asset_liability_status', 0)->get();
        foreach($asset_2nd_level_gls as $asset_2nd_level_gl){
            $asset_gl_list_array['root_gl'][$asset_2nd_level_gl->mother_ac_no]['second_level_gl'][$asset_2nd_level_gl->acc_no] = [
                "account_name"   => $asset_2nd_level_gl->acc_name,
                "account_no"     => $asset_2nd_level_gl->acc_no,
                "balance"        => $this->accountBalanceSummation($asset_2nd_level_gl->acc_no),
                "third_level_gl" => []
            ];
        }

        // level 3 gl
        $asset_3rd_level_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no', 'mother_ac_no'])->where('gl_level', 3)->where('asset_liability_status', 0)->get();
        foreach($asset_3rd_level_gls as $asset_3rd_level_gl){
            $mother_gl = $this->getMotherGl($asset_3rd_level_gl->mother_ac_no);
            $asset_gl_list_array['root_gl'][$mother_gl]['second_level_gl'][$asset_3rd_level_gl->mother_ac_no]['third_level_gl'][$asset_3rd_level_gl->acc_no] = [
                "account_name" => $asset_3rd_level_gl->acc_name,
                "account_no"   => $asset_3rd_level_gl->acc_no,
                "balance"      => $this->accountBalanceSummation($asset_3rd_level_gl->acc_no)
            ];
        }

        foreach($asset_gl_list_array['root_gl'] as $asset_gl){
            if(count($asset_gl['second_level_gl']) > 0){
                foreach($asset_gl['second_level_gl'] as $second_level_gl){
                    if(count($second_level_gl['third_level_gl']) > 0){
                        $total_child_balance = $this->sumChildBalance($second_level_gl['third_level_gl']);
                        $asset_gl_list_array['root_gl'][$asset_gl['account_no']]['second_level_gl'][$second_level_gl['account_no']]['balance'] = $total_child_balance;
                    }
                }
            }
        }

        foreach($asset_gl_list_array['root_gl'] as $asset_gl){
            if(count($asset_gl['second_level_gl']) > 0){
               $total_child_ac_balance = $this->sumChildBalance($asset_gl['second_level_gl']);
               $asset_gl_list_array['root_gl'][$asset_gl['account_no']]['balance'] = $total_child_ac_balance;
            }
        }

        return $asset_gl_list_array;

    }

    /**
    * This function return liability gl list array
    *
    */
    public function getLiabilityGlBalance(){
        $liability_gl_list_array = [];

        // level 1 gl
        $liability_root_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no'])->where('gl_level', 1)->where('asset_liability_status', 1)->get();
        foreach($liability_root_gls as $liability_root_gl){
            $liability_gl_list_array['root_gl'][$liability_root_gl->acc_no] = [
                "account_name"    => $liability_root_gl->acc_name,
                "account_no"      => $liability_root_gl->acc_no,
                "balance"         => $this->accountBalanceSummation($liability_root_gl->acc_no),
                "second_level_gl" => []
            ];
        }

        // level 2 gl
        $liability_2nd_level_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no', 'mother_ac_no'])->where('gl_level', 2)->where('asset_liability_status', 1)->get();
        foreach($liability_2nd_level_gls as $liability_2nd_level_gl){
            $liability_gl_list_array['root_gl'][$liability_2nd_level_gl->mother_ac_no]['second_level_gl'][$liability_2nd_level_gl->acc_no] = [
                "account_name"   => $liability_2nd_level_gl->acc_name,
                "account_no"     => $liability_2nd_level_gl->acc_no,
                "balance"        => $this->accountBalanceSummation($liability_2nd_level_gl->acc_no),
                "third_level_gl" => []
            ];
        }

        // level 3 gl
        $liability_3rd_level_gls = DB::table('gl_accounts')->select(['acc_name', 'acc_no', 'mother_ac_no'])->where('gl_level', 3)->where('asset_liability_status', 1)->get();
        foreach($liability_3rd_level_gls as $liability_3rd_level_gl){
            $mother_gl = $this->getMotherGl($liability_3rd_level_gl->mother_ac_no);
            $liability_gl_list_array['root_gl'][$mother_gl]['second_level_gl'][$liability_3rd_level_gl->mother_ac_no]['third_level_gl'][$liability_3rd_level_gl->acc_no] = [
                "account_name" => $liability_3rd_level_gl->acc_name,
                "account_no"   => $liability_3rd_level_gl->acc_no,
                "balance"      => $this->accountBalanceSummation($liability_3rd_level_gl->acc_no)
            ];
        }

        foreach($liability_gl_list_array['root_gl'] as $liability_gl){
            if(count($liability_gl['second_level_gl']) > 0){
                foreach($liability_gl['second_level_gl'] as $second_level_gl){
                    if(count($second_level_gl['third_level_gl']) > 0){
                        $total_child_balance = $this->sumChildBalance($second_level_gl['third_level_gl']);
                        $liability_gl_list_array['root_gl'][$liability_gl['account_no']]['second_level_gl'][$second_level_gl['account_no']]['balance'] = $total_child_balance;
                    }
                }
            }
        }

        foreach($liability_gl_list_array['root_gl'] as $liability_gl){
            if(count($liability_gl['second_level_gl']) > 0){
               $total_child_ac_balance = $this->sumChildBalance($liability_gl['second_level_gl']);
               $liability_gl_list_array['root_gl'][$liability_gl['account_no']]['balance'] = $total_child_ac_balance;
            }
        }

        return $liability_gl_list_array;
    }

    /**
    * This function return total summation in a/c
    *
    */
    public function accountBalanceSummation($account_no){
        $total_cr = DB::select(DB::raw("SELECT  sum(amount) as total_cr from `transaction` where acc_no ='$account_no' and trnTp ='cr'"));
        $total_dr = DB::select(DB::raw("SELECT  sum(amount) as total_dr from `transaction` where acc_no ='$account_no' and trnTp ='dr'"));

        $final_cr =  $total_cr[0]->total_cr ? $total_cr[0]->total_cr : 0;
        $final_dr =  $total_dr[0]->total_dr ? $total_dr[0]->total_dr : 0;
        return $final_cr - $final_dr;
        
    }

    /**
    * This function summation all child account balance
    *
    */
    private function sumChildBalance($childAccountArray){
        $balance = 0;
        foreach($childAccountArray as $account){
            $balance += $account['balance'];
        }
        return $balance;
       
    }

    public function gl_balance()
    {
        return view('gl.accounts.report.glbalance.gl_balance');   
    }

    public function glIndex()
    {
        return view('gl.accounts.report.glbalance.transaction_gl');   
    }





}
