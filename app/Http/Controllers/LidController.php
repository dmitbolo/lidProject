<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LidRequest;
use App\Models\Lid;
use App\Models\Status;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LidController extends Controller
{
    public function index(): \Inertia\Response
    {
        $lids = Lid::all();
        $status = Status::all();
        $lidsCount = count($lids);
        $newLidCount = count(Lid::where('status_id', 1)->get());
        $inProgressLidCount  = count(Lid::where('status_id', 2)->get());
        $completedLidCount = count(Lid::where('status_id', 3)->get());
        return Inertia::render('Lids', [
            'lids' => $lids,
            'lidsCount' => $lidsCount,
            'newLidCount' => $newLidCount,
            'inProgressLidCount' => $inProgressLidCount ,
            'completedLidCount' => $completedLidCount,
            'status' => $status,
        ]);
    }

    public function edit($id): \Inertia\Response
    {
        $lid = Lid::findorfail($id);
        return Inertia::render('Lids/Edit', [
            'lid' => $lid,
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Lids/Create');
    }

    public function store(LidRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData["status_id"] = 1;
        Lid::create($validatedData);
        return Redirect::to('/');
    }

    public function update(LidRequest $request): \Illuminate\Http\RedirectResponse
    {
        $id = $request->id;
        $validatedData = $request->validated();

        $lid = Lid::find($id);
        $lid->fill($validatedData);
        $lid->save();

        return back();
    }

    public function editStatus(Request $request): array
    {
        $id = $request->id;
        $validatedData = $request->validate([
            'status_id' => 'required|integer|between:1,3',
        ]);

        $lid = Lid::find($id);
        $old_status_id = $lid->status_id;
        $lid->fill($validatedData);
        $lid->save();

        return [$request->status_id, $old_status_id];
    }

    public function destroy(Request $request): void
    {
        $id = $request->id;
        $lid = Lid::find($id);
        $lid->delete();
    }
}
