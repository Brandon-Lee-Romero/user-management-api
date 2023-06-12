<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BulkDestroyRequest;
use App\Models\User;

class BulkDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BulkDestroyRequest $request)
    {       
        $validated = $request->safe()->all();
        
        $bulkDestroy = User::whereIn('id', $validated['id'])->delete();

        if(!$bulkDestroy)  return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 422);

        return response()->json([
            'status' => 'success', 
            'message' => 'Users deleted successfully '
        ]);

    }
}
