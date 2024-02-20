<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Traits\Uploadable;
use App\Repositories\Transaction\PaymentMethodRepository;

class SettingController extends Controller
{
    use Uploadable;

    protected $image_path = 'upload_files/settings';

    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        return inertia('Admin/Setting/Index')->with([
            'setting' => Setting::first() ?? [],
            'paymentMethods' => (new PaymentMethodRepository())->getAllActivated()
        ]);
    }

    public function store(SettingRequest $request)
    {
        try {
            $setting = Setting::first();
            $input = $request->all();
            
            if($setting) {
                if($request->hasFile('logo')){
                    $this->deleteFile($setting->logo, $this->image_path);
                    $file = $request->file('logo')->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    $filename = $this->uploadFile($request->file('logo'), $filename, $this->image_path);
                    $input['logo'] = $filename;
                } else {
                    $input['logo'] = $setting->logo;
                }

                if($request->hasFile('signed_image')){
                    $this->deleteFile($setting->signed_image, $this->image_path);
                    $file = $request->file('signed_image')->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
                    $filename = $this->uploadFile($request->file('signed_image'), $filename, $this->image_path);
                    $input['signed_image'] = $filename;
                } else {
                    $input['signed_image'] = $setting->signed_image;
                }

                $setting->update($input);
            } else {
                if($request->hasFile('logo')){
                    $file = $request->file('logo')->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
    
                    $filename = $this->uploadFile($request->file('logo'), $filename, $this->image_path);
                    $input['logo'] = $filename;
                }

                if($request->hasFile('signed_image')){
                    $file = $request->file('signed_image')->getClientOriginalName();
                    $filename = pathinfo($file, PATHINFO_FILENAME);
    
                    $filename = $this->uploadFile($request->file('signed_image'), $filename, $this->image_path);
                    $input['signed_image'] = $filename;
                }

                Setting::create($input);
            }

            return redirect()->route('admin.settings.index');

        } catch(\Exception $e) {
            #get message
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            #redirect
            return redirect()->back()->withInput($request->all());
        }

        
    }
}

