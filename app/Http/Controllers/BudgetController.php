<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:budget-list|budget-create|budget-edit|budget-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:budget-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:budget-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:budget-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = Budget::all();
        return view('budget.index', compact($budgets, 'budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('budget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'head' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $budget = $request->all();
        $budget['balance'] = $request->amount;
        Budget::create($budget);
        return redirect()->route('budget.create')->with('message', 'Budget head has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        return view('budget.show', compact($budget, 'budget'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        return view('budget.edit', compact($budget, 'budget'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        $budget->head = $request->head;
        $budget->amount = $request->amount;
     //   $budget->balance = $request->balance;
        $budget->update();
        return redirect()->route('budget.index')->with('message', 'Budget head has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budget.index')->with('message', 'Budget head has been deleted successfully');
    }
}
