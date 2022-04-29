<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data['user_expense'] = Expense::where('user_id', Auth::user()->id)->paginate();
      //  dd($data['user_expense']);
        $data['expense_count'] = Expense::where('user_id', Auth::user()->id)->count();
        return view('home', compact('data', 'user'))->with('i', ($request->input('page', 1)- 1) *5);
    }

}
