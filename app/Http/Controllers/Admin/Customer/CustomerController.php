<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\City;
use App\Models\State;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('Admin.Customer.index', compact('customers'));
    }
    public function getCustomerAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $columns = ['id', 'name', 'address', 'mobile', 'details', 'action'];

            $orderColIndex = intval($request->input('order.0.column'));
            // Use a default column if index is out of bounds or for action column (which is not orderable)
            $orderCol = $columns[$orderColIndex] ?? 'id';
            // Ensure you don't try to order by columns marked as not orderable on the frontend (action, detail)
            if ($orderCol === 'action' || $orderCol === 'details') {
                $orderCol = 'id'; // Fallback to 'id' for ordering non-database columns
            }

            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');

            // --- Correction: Start with a Query Builder instance ---
            $query = Customer::query();

            // Count total records *before* filtering
            $recordsTotal = $query->count();

            // --- Apply Filtering (Search) on the Query Builder instance ---
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    // Ensure 'name' and 'id' exist on your Customer model
                    $q->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('id', 'like', "%{$searchValue}%")
                        // You should probably add more searchable fields here, e.g., address, mobile, email
                        ->orWhere('address', 'like', "%{$searchValue}%")
                        ->orWhere('mobile', 'like', "%{$searchValue}%");
                });
            }

            // Count filtered records
            $recordsFiltered = $query->count();

            // --- Apply Ordering and Pagination on the Query Builder instance ---
            $records = $query->orderBy($orderCol, $orderDir)
                ->offset($start)
                ->limit($length)
                ->get(); // Finally execute the query to get the records

            $dataArr = [];
            foreach ($records as $data) {
                // The frontend table columns are: Id, Customer, Address, Contact, Details, Action
                $action = '<div class="edit-delete-action float-end">
                            <a href="' . route('customer.edit', $data->id) . '" class="me-2 p-2 text-success">
                                <i data-feather="edit" class="feather-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="p-2 text-danger remove-item-btn" data-id="' . $data->id . '">
                                <i data-feather="trash-2" class="feather-trash-2"></i>
                            </a>
                        </div>';

                $dataArr[] = [
                    'id'      => $data->id,
                    // Make sure these keys match the 'data' properties in your DataTables columns configuration
                    'name'    => $data->name ?? '',
                    'address' => $data->address ?? '',
                    // Assuming 'contact' in frontend maps to 'mobile' or 'email' or a concatenated value
                    'contact' => ($data->mobile ?? '') . ' / ' . ($data->email ?? ''), // Display mobile/email under Contact column
                    'detail'  => $data->details ?? '', // Renamed from 'details' to 'detail' to match frontend config
                    'action'  => $action,
                ];
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ]);
        }
    }

    public function create()
    {
        $states = State::all();
        return view('Admin.Customer.create', compact('states'));
    }
    public function getCitiesByState(Request $request)
    {
        $request->validate([
            'state_id' => 'required|integer|exists:states,id',
        ]);

        $stateId = $request->state_id;
        $cities = City::where('state_id', $stateId)
            ->select('id', 'city')
            ->orderBy('city', 'asc')
            ->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|min:3|unique:customers,name|regex:/^[a-zA-Z ]+$/',
            'address'           => 'required|min:3',
            'mobile'            => 'required|digits:10|unique:customers,mobile',
            'email'             => 'required|email|unique:customers,email',
            'details'           => 'required|min:3',
            'previous_balance'  => 'nullable|numeric',
            'state_id'  => 'required|integer|exists:states,id',
            'city_id'  => 'required|integer|exists:cities,id',
        ]);

        Customer::create([
            'name'              => $request->name,
            'address'           => $request->address,
            'mobile'            => $request->mobile,
            'email'             => $request->email,
            'details'           => $request->details,
            'state_id'         => $request->state_id,
            'city_id'          => $request->city_id,
            'previous_balance'  => $request->previous_balance,
        ]);

        return redirect()->back()->with('message', 'Customer added successfully');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $states = State::all();
        $selectedCities = [];
        if ($customer->state_id) {
            $selectedCities = City::where('state_id', $customer->state_id)
                ->select('id', 'city')
                ->orderBy('city', 'asc')
                ->get();
        }
        return view('Admin.Customer.edit', compact('customer', 'states', 'selectedCities'));
    }

    public function update(Request $request)
    {
        $customer = Customer::findOrFail($request->id);

        $request->validate([
            'name'     => 'required|min:3|regex:/^[a-zA-Z ]+$/|unique:customers,name,' . $customer->id,
            'address'  => 'required|min:3',
            'mobile'   => 'required|digits:10|unique:customers,mobile,' . $customer->id,
            'email'    => 'required|email|unique:customers,email,' . $customer->id,
            'details'  => 'required|min:3',
            'state_id'  => 'required|integer|exists:states,id',
            'city_id'  => 'required|integer|exists:cities,id',
            'previous_balance' => 'nullable|numeric',
        ]);

        $customer->update([
            'name'              => $request->name,
            'address'           => $request->address,
            'mobile'            => $request->mobile,
            'email'             => $request->email,
            'details'           => $request->details,
            'state_id'         => $request->state_id,
            'city_id'          => $request->city_id,
            'previous_balance'  => $request->previous_balance,
        ]);

        return redirect()->route('customer')->with('success', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('message', 'Customer deleted successfully');
    }
}
