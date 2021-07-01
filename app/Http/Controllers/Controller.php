<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\DataRequest;
use App\Http\Requests\FileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**Show form to get data
     *
     * @return view
    */
    public function index () {
        return view('form');
    }

    /**Get data from form
     *
     * @
     */
    public function store(DataRequest $request) {
        $value = $request->status;
        dd($value);
    }

    /**Show form upload file
     *
     * @return view
     */
    public function showForm() {
        return view('formUpload');
    }

    /**Store file
     *
     * @return bool
     */
    public function uploadFiles(FileRequest $request) {
        $status = true;
        foreach ($request->file('files') as $file) {
            $name = time().'_'.$file->getClientOriginalName();;
            $result = $file->storeAs('files', $name);
             if (!$result) {
                $status = false;
             }
        }
        if(!$status) {
            echo '<div class="alert alert-warning"> Upload failed </div>';
        } else {
            echo '<div class="alert alert-success"> Upload successfully </div>';
        }
    }

}
