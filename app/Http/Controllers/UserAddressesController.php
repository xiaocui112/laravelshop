<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

/**
 * 地址操作类
 *
 */
class UserAddressesController extends Controller
{
    /**
     * 地址详情
     *
     * @param Request $request
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user_addresses.index', ['addresses' => $request->user()->addresses]);
    }
    /**
     * 新建地址
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }
    /**
     * 储存收获地址
     *
     * @param UserAddressRequest $request
     * @return Illuminate\View\View
     */
    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        return redirect()->route('user_addresses.index');
    }
    /**
     * 修改收货地址
     *
     * @param UserAddress $userAddress
     * @return Illuminate\View\View
     */
    public function edit(UserAddress $userAddress)
    {
        $this->authorize('own', $userAddress);
        return view('user_addresses.create_and_edit', ['address' => $userAddress]);
    }
    /**
     * 修改地址
     *
     * @param UserAddress $userAddress
     * @param UserAddressRequest $request
     * @return Illuminate\View\View
     */
    public function update(UserAddress $userAddress, UserAddressRequest $request)
    {
        $this->authorize('own', $userAddress);
        $userAddress->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }
    /**
     * 删除地址
     *
     * @param UserAddress $user_address
     * @return Illuminate\View\View
     */
    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        $user_address->delete();

        return [];
    }
}
