<?php

namespace App\Repositories;

use App\Models\AnnualLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnualLeaveRepository
{
    public function show($id) {
        $userId = Auth::user()->id;
        $leave = AnnualLeave::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        return $leave;
    }

    public function paginate() {
        return AnnualLeave::paginate();
    }
    
    public function store(Request $request, $status = AnnualLeave::STATUS['pending']) : AnnualLeave {
        
        $leave = new AnnualLeave($request->only([
            'start_date',
            'end_date',
            'description',
        ]));

        $leave->user_id = Auth::user()->id;
        $leave->status = $status;
        // save 
        $leave->save();
        return $leave;
    }
}
