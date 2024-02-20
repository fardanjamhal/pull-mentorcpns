<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\VoucherRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Http\Requests\Transaction\VoucherRequest;
use App\Models\MasterData\SubCategory;
use \App\Models\Transaction\Voucher;
use App\Repositories\User\MemberCategoryRepository;

class VoucherController extends Controller
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Transaction/Voucher/Index', [
            'vouchers' => $this->voucherRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Transaction/Voucher/Create', [
            'categories' => (new CategoryRepository())->all(),
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        try {
            $this->voucherRepository->create($request);

            return redirect()->route('admin.vouchers.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->voucherRepository->find($id)) return abort('404', 'uppss....');

        $voucher = Voucher::with(['subCategories' => function ($query) {
            $query->select('sub_categories.id', 'sub_categories.name');
        }])->find($id);

        $subCategories = $voucher->subCategories;

        return inertia('Admin/Transaction/Voucher/Edit', [
            'voucher' => $this->voucherRepository->find($id),
            'categories' => (new CategoryRepository())->all(),
            'subCategories' => $subCategories,
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, $id)
    {
        try {
            if(!$this->voucherRepository->find($id)) return abort('404', 'uppss....');

            $this->voucherRepository->update($request, $id);

            return redirect()->route('admin.vouchers.index');

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
            $this->voucherRepository->delete($id);

            return redirect()->route('admin.vouchers.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }
}
