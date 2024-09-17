<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\LawyerRepository;
use App\Models\Lawyer;
use DB;
use App\Http\Controllers\Base\SingleInputFieldController;

class DashboardController extends Controller
{

    protected $customerRepository;
    protected $lawyerRepository;

    public function __construct(CustomerRepository $customerRepository,LawyerRepository $lawyerRepository)
    {
        // Inject the CustomerRepository
        $this->customerRepository = $customerRepository;
        $this->lawyerRepository=$lawyerRepository;
    }
    public function index()
    {
        $customerCount=Customer::count();
        $lawyerCount=Lawyer::count();
        return view('dashboard',['customerCount'=>$customerCount,'lawyerCount'=>$lawyerCount]);
    }

    public function weeklyEnrollementCustomer(Request $request)
    {
        return $this->customerRepository->weeklyEnrollementData($request);
    }
    

 
    public function weeklyEnrollementLawyer(Request $request)
    {
        return $this->lawyerRepository->weeklyEnrollementData($request);
       



    }
}
