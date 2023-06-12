<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{
    StoreRequest,
    UpdateRequest,
    ListRequest
};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListRequest $request)
    {
        /* get only the validated fields */
        $validated = $request->safe()->all();

        $sort = $validated['sort'] ?? 'id';

        $order = $validated['order'] ?? 'desc';

        $limit = $validated['limit'] ?? 50;

        $data = User::where('type', '!=', 1);

        if (isset($validated['search'])) {
            $search = $validated['search'];
            $data = $data->where(function ($query) use ($search) {
                $query->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%")
                    ->orWhere('postcode', 'like', "%$search%")
                    ->orWhere('contact_number', 'like', "%$search%")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%");
            });
        }

        $data = $data->orderBy($sort, $order)->paginate($limit);

        $data->getCollection()->transform(function ($user) {
            unset($user->type);
            return $user;
        });


        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        /* Get the validated data */
        $validated = $request->getData();

        $data = User::create($validated);

        if (!$data) return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 422);

        return response()->json([
            'status' => 'success',
            'message' => 'Users created successfully',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);

        if (!$data) return response()->json(['status' => 'error', 'message' => 'No user found'], 404);

        unset($data->type);

        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $data,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validated = $request->getData();

        $data = User::find($id);

        if (!$data) return response()->json(['status' => 'error', 'message' => 'Failed to update user: no user found'], 404);

        $data->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        if (!$data) return response()->json(['status' => 'error', 'message' => 'Failed to delete user: no user found'], 404);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ]);
    }
}
