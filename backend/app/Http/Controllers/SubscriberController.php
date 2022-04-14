<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::all();

        return SubscriberResource::collection($subscribers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubscriberRequest $request)
    {
        DB::beginTransaction();
        try {
            $subscriber = Subscriber::create($request->all());

            $fieldsData = collect($request->input('fields'))->map(function ($item, $key) {
                return ['value' => $item];
            });
            $subscriber->fields()->attach($fieldsData);

            DB::commit();
            return new SubscriberResource($subscriber);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json(['status' => false, 'message' => 'Operation Failed.'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        return new SubscriberResource($subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber)
    {
        DB::beginTransaction();
        try {
            $subscriber->update($request->all());
            $fieldsData = collect($request->input('fields'))->map(function ($item, $key) {
                return ['value' => $item];
            });
            $subscriber->fields()->sync($fieldsData);

            DB::commit();
            return new SubscriberResource($subscriber);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json(['status' => false, 'message' => 'Operation Failed.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $responseData = ['status' => false];
        if ($subscriber->delete()) {
            $responseData['status'] = true;
        }
        return Response::json($responseData);
    }
}
