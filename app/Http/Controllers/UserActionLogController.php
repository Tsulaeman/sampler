<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs =  Auth::user()->userActionLogs()->get();
        return response([
            'logs' => $logs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserActionLog $userActionLog)
    {
        return response([
            'log' => $userActionLog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserActionLog $userActionLog)
    {
        //
    }
}
