<?php

namespace App\Http\Controllers\Billar\Expense;

use App\Filters\Billar\Purpose\PurposeFilter;
use App\Http\Controllers\Controller;
use App\Models\Billar\Expense\Purpose;
use Illuminate\Http\Request;

class PurposeController extends Controller
{

    public function __construct(PurposeFilter $purposeFilter)
    {
        $this->filter = $purposeFilter;
    }

    public function index()
    {
        return Purpose::filters($this->filter)
            ->paginate(\request('per_page', 15));
    }

    public function show(Purpose $purpose)
    {
        return $purpose;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required'
        ]);
        Purpose::create($request->all());

        return created_responses('purpose');
    }

    public function update(Request $request, Purpose $purpose)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required'
        ]);
        $purpose->update($request->all());

        return updated_responses('purpose');
    }

    public function destroy(Purpose $purpose)
    {

        $purpose->delete();

        return deleted_responses('purpose');
    }


    public function getPurposeList()
    {
        return Purpose::query()
            ->where('type', \request('type', null))
            ->select('name', 'id')
            ->get();
    }
}
