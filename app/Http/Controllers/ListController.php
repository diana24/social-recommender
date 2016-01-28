<?php

namespace App\Http\Controllers;

use App\UserList;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Auth::user()->lists()->get());

    }

    public function store(Request $request)
    {
        if( $request->get('name')){
            $list = new UserList();
            $list->name = $request->get('name');
            Auth::user()->lists()->save($list);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return json_encode(Auth::user()->lists()->get($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addToList(Request $request){
        $listid=$request->get('list_id');
        $itemid=$request->get('item_id');
        $list = Auth::user()->lists()->get($listid);
        if($list){
            $item=Auth::user()->savedItems()->get($itemid);
            if($item){
                $list->savedItems()->attach($itemid,[]);
            }
        }
    }

    public function addItem(Request $request){
        $uri = $request->input('uri');
        $type = $request->input('type');
        $body = $request->input('body');
        $status = $request->input('status');
    }
}
