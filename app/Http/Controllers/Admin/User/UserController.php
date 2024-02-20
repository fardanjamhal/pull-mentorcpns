<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository as UserRepository;
use App\Http\Requests\User\UserRequest;
use App\Models\Setting;
use App\Models\UserMemberCategory;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/User/User/Index', [
            'users' => $this->userRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/User/User/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userRepository->create($request);
            return redirect()->route('admin.users.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            return redirect()->back()->withInput($request->all());
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
        $user = $this->userRepository->find($id);
        $setting = Setting::first();
        
        return inertia('Admin/User/User/Show', [
            'user' => $user,
            'verificationLink' => urldecode(($setting->app_url ?? 'Atur Setting Terlebih Dahulu').'/user/'.$user->id.'/activation')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return inertia('Admin/User/User/Edit', [
            'user' => $this->userRepository->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $this->userRepository->update($request, $id);
            return redirect()->route('admin.users.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return redirect()->route('admin.users.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function activationReminder($id)
    {
        if(!$this->userRepository->find($id)) return abort('404', 'uppss....');

        $user = $this->userRepository->find($id);

        $setting = Setting::first();

        $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari ".($setting->app_name ?? "isi data setting terlebih dahulu").", akun anda telah terdaftar di platform kami, berikut akun anda._\n\nNama: ".$user->name."\nEmail: ".$user->email."\n\n*saat ini anda belum mengaktifkan akun anda, apakah ada kendala ketika aktivasi ? atau belum mendapatkan link aktivasi ?*\n\n *jika tidak diaktivasi maka dalam jangka waktu lama akun akan terhapus secara otomatis.*\n\n_terimakasih telah menjadi bagian dari kami, semoga kami dapat membantu anda lolos terpilih. aamiin._";
        
        sendWhatsappNotification($user->student->phone_number, $message);    

        return redirect()->back()->with('success', 'Reminder telah dikirim.');
    }

    public function sendActivationLink($id)
    {
        if(!$this->userRepository->find($id)) return abort('404', 'uppss....');

        $user = $this->userRepository->find($id);

        $user->update(['expiry_verification_date' => Carbon::now()->addDays(1)]);
        $setting = Setting::first();

        $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari ".($setting->app_name ?? "isi data setting terlebih dahulu").", akun anda telah terdaftar di platform kami, berikut link untuk aktivasi akun anda._\n\nNama: ".$user->name."\nEmail: ".$user->email."\n\nBerikut link verifikasi anda\n".($setting->app_url ?? "isi-setting-terlebih-dahulu")."/user/".$user->id."/activation \n\n*Jika link tidak bisa diklik, silakan copy dan paste dibrowser anda.*\n\n_terimakasih telah menjadi bagian dari kami, semoga kami dapat membantu anda lolos terpilih. aamiin._";
        sendWhatsappNotification($user->student->phone_number, $message);

        return redirect()->back()->with('success', 'Link Aktivasi telah dikirim.');
    }

    public function memberReminder($id)
    {
        if(!$this->userRepository->find($id)) return abort('404', 'uppss....');

        $user = $this->userRepository->find($id);

        $setting = Setting::first();

        $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu")).", akun anda telah terdaftar di platform kami, berikut akun anda._\n\nNama: ".$user->name."\nEmail: ".$user->email."\n\nsaat ini anda belum mengaktifkan member anda, yuk aktifkan akunmu sekarang juga.\n\n_terimakasih telah menjadi bagian dari kami, semoga kami dapat membantu anda lolos terpilih. aamiin._";
        
        sendWhatsappNotification($user->student->phone_number, $message);    

        return redirect()->back()->with('success', 'Reminder Member telah dikirim.');
    }

    public function destroyUserMemberCategory($userId, $memberCategoryId)
    {
        if(!$this->userRepository->find($userId)) return abort('404', 'uppss....');

        $userMemberCategory = UserMemberCategory::findOrFail($memberCategoryId);
        $userMemberCategory->delete();

        return redirect()->back()->with('success', 'Akses Kategori Member Telah Dihapus.');
    }
}
