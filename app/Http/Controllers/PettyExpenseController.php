<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Petty_expense;
use App\Models\Petty_Expense_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PettyExpenseController extends Controller
{
    public function index(Request $request){
        $pettys = Petty_expense::with('petty_expense_items')->paginate(10);
        
        return view('petty-expense.index', compact('pettys'))->with('i', ($request->input('page', 1)- 1) *5);
    }

    public function create(){
        $users = User::where('designation', 'hod')->get();
       return view('petty-expense.create', compact('users'));
    }

    public function store(Request $request){
       
        //validation
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'total' => 'integer|required',
            'comment'=> 'nullable|string',
            'invoice' => 'nullable|image|mimes:png,jpg,jpeg'

        ], $messages = [
            'description.required' => 'The expense description is required.',
            'comment.string' => 'Comments should be in string characters.'
            
        ]);

        if($validator->fails()){
            return back()->with(['message' => $validator->errors()]);
        }
        //Check if request has file.
      if($request->hasFile('invoice')){
        $fileNameExtension = $request->file('invoice')->getClientOriginalName();
        $fileExtension = $request->file('invoice')->getClientOriginalExtension();
        $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME);
        $nameToStore = $fileName.'_'.time().'.'.$fileExtension;
        $path = $request->file('invoice')->move(public_path('uploads/invoices'), $nameToStore);
      }

      
      $firstName = Auth::user()->fname;
      $lastName = Auth::user()->lname;
      $userId = Auth::user()->id;
      $userDept = Auth::user()->dept;
      $petty = new Petty_expense();
      $petty['exp_no'] = mt_rand(10,10000);
      $petty['description'] = $request->description;
      $petty['prep_by'] = $firstName. ' '. $lastName;
      $petty['user_id'] = $userId;
      $petty['dept'] = $userDept;
      $petty['total'] = $request->total;
      $petty['comment'] = $request->comment;
      $petty['apprv_by'] = $request->apprv_by;
      $petty->save();

      foreach ($request->multi as $key => $value) {
        $petty->petty_expense_items()->create($value);
      }
// Send notification to admin
      return redirect()->route('pettyexpense.index')->with('message', 'Petty expense has been created');

    }

    public function show(Petty_expense $petty){
        $i = 0;
        $pitems = Petty_Expense_item::where('petty_expense_id', $petty->id)->get();
        return view('petty-expense.show', compact('petty', 'pitems', 'i'));
        

    }

    public function edit(Petty_expense $petty){
        return view('petty-expense.edit', compact('petty'));


    }

    public function update(Request $request){
        return "This action is yet to be activated by the admin...";

    }

    public function destroy(Petty_expense $petty){
        return "This action is yet to be activated by the admin...";

    }

    // Send Petty xpense for approval
    public function sendPettyExpense(Petty_expense $petty){
        // Check for approval.
        if($petty->hod_apprv == 1){

            return redirect()->back()->with('message', 'This petty expense has already been approved for execution.');

        }else{

            // Send notification to HOD.
        }

    }

    public function hodPettyApproval(Petty_expense $petty){
        //Check for Approval.
        if($petty->hod_apprv == 1){

            return back()->with('message', 'You have been already approved this expense');

        }else{

            $petty->hod_apprv = 1;
            $petty->save();

        }

    }

    public function cfopettyApproval(Petty_expense $petty){
        if ($petty->cfo_apprv == 1) {
            return back()->with('message', 'Oops! You have already apporved this expense');
           
        }elseif ($petty->hod_apprv == 0) {
            return back()->with('message', 'Oops! Petty expense has not been approved by dept head.');
            # code...
        }else{
            $petty->cfo_apprv = 1;
            // Send notification to payment initiator
        }

    }

    public function addComment(Request $request, Petty_expense $petty){
        $petty->cfo_comment = $request->cfo_comment;
        $petty->save();

    }


}
