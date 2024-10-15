<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnualLeaveStore;
use App\Http\Resources\AnnualLeaveResource;
use App\Repositories\AnnualLeaveRepository;

class AnnualLeaveController extends Controller
{

    public function index() {
        $leaveRepo = new AnnualLeaveRepository();
        $leaves = $leaveRepo->paginate();
        
        return response()->json([
            'status' => 'success',
            'data' => AnnualLeaveResource::collection($leaves)
        ]);

    }

    public function store(AnnualLeaveStore $request){

        $leaveRepo = new AnnualLeaveRepository();
        $leave = $leaveRepo->store($request);

        return response()->json([
            'status' => 'success',
            'data' => new AnnualLeaveResource($leave)
        ]);

    }

    public function show($id) {
        $leaveRepo = new AnnualLeaveRepository();
        $leave = $leaveRepo->show($id);

        if(is_null($leave)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Annual leave is not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => new AnnualLeaveResource($leave)
        ]);
    }
}
