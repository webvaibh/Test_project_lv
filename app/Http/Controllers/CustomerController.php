<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // function to save customers in database
    public function saveCustomer(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'countryCode' => 'required',
            'mobile' => 'required|min:10|max:13|unique:customers,mobile',
            'status' => 'required',
        ]);

        if ($validate) {
            $temp_country_code = $request->input('countryCode');
            $country_name = substr($temp_country_code, strpos($temp_country_code, "-") + 1);
            $country_code = strtok($temp_country_code, '-');

            $customer_data = new Customer;
            $customer_data->name = $request->input('name');
            $customer_data->country_code = $country_code;
            $customer_data->mobile = $request->input('mobile');
            $customer_data->status = $request->input('status');
            $customer_data->country_name = $country_name;
            $status = $customer_data->save();

            if ($status) {
                return redirect()->route('add_customer')->with("status", "Customer Add Succesfully");
            } else {
                return redirect()->route('add_customer')->with("status", "Something Went Wrong Please Try Again !!");
            }
        }
    }

    // function to show list of customers
    public function showCustomers()
    {
        $customers = Customer::all();
        if( count($customers) != 0 ) {
            return view("home", ['customers_data' => $customers]);
        } else {
            return view("home", ['customers_data' =>['status' => 'empty']]);
        }

    }

    // function to edit the customer
    public function editCustomer(Request $request, $id)
    {

        $edit_customer = Customer::find($id);
        return view('editCustomer', ["edit_customer_data" => $edit_customer]);
    }

    // function to save the updated data of customer
    public function saveEditCustomer(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'mobile' => 'required|min:10|max:13',
            'status' => 'required',
        ]);
        if ($validate) {

            $temp_country_code = $request->input('countryCode');
            $country_name = substr($temp_country_code, strpos($temp_country_code, "-") + 1);
            $country_code = strtok($temp_country_code, '-');

            $customer_id = $request->input('customer_id');
            $edit_customer = Customer::find($customer_id);
            $edit_customer->name = $request->input('name');
            $edit_customer->country_code = $country_code;
            $edit_customer->mobile = $request->input('mobile');
            $edit_customer->status = $request->input('status');
            $edit_customer->country_name = $country_name;
            $status = $edit_customer->save();

            if ($status) {
                return redirect()->route('home')->with("status", "Customer Updated Succesfully");
            } else {
                return redirect()->route('home')->with("status", "Something Went Wrong Please Try Again !!");
            }
        }
    }

    // function to Delete the customer
    public function deleteCustomer($id)
    {
        $delete_customer = Customer::find($id)->delete();
        
        if ($delete_customer) {
            return redirect()->route('home')->with("status_delete", "Customer Deleted");
        } else {
            return redirect()->route('home')->with("status_delete", "Something Went Wrong Please Try Again !!");
        }
        
    }
}