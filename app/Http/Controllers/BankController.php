<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * TODO:: Permissions is need to change
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('Manage Branch')) {
            $aBanks = Bank::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('bank.index', compact('aBanks'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('Create Branch')) {
            return view('bank.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Branch')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $branch             = new Bank();
            $branch->name       = $request->name;
            $branch->created_by = \Auth::user()->creatorId();
            $branch->save();

            return redirect()->route('bank.index')->with('success', __('Bank  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        if (\Auth::user()->can('Edit Branch')) {
            if ($bank->created_by == \Auth::user()->creatorId()) {

                return view('bank.edit', compact('bank'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        if (\Auth::user()->can('Edit Branch')) {
            if ($bank->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $bank->name = $request->name;
                $bank->save();

                return redirect()->route('bank.index')->with('success', __('Bank successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (\Auth::user()->can('Delete Branch')) {
            if ($bank->created_by == \Auth::user()->creatorId()) {
                $employee     = Employee::where('bank_id', $bank->id)->get();
                if (count($employee) == 0) {
                    $bank->delete();
                } else {
                    return redirect()->route('bank.index')->with('error', __('This bank has employees. Please remove the employee from this bank.'));
                }

                return redirect()->route('bank.index')->with('success', __('Bank successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
