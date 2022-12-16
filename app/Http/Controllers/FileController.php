<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckinRequest;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\Group;

class FileController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(File::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app('services')->FileService->GetFilesForUser();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        return app('services')->FileService->store($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return app('services')->FileService->GetFileForRead($file);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileRequest  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        return app('services')->FileService->CheckOut($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        return app('services')->FileService->DeleteFile($file);
    }

    public function addFileToGroup(File $file,Group $group)
    {
        return app('services')->FileService->addFileToGroup($file,$group);
    }

    public function CheckIn(CheckinRequest $request)
    {
        return app('services')->FileService->CheckIn($request->validated());
    }
}
