<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Requests\MassDestroyTeamRequest;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $search = $request['search'];
        $teams = Team::latest();
        if ($request['search']) {
            $teams = $teams->where('name', 'like', '%' . $search . '%');
        }
        $teams = $teams->paginate(config('app.paginate'));
        if ($request->ajax()) {
            $teamSearch = view('admin.teams.teamtable',compact('teams'))->render();
            return response()->json(['teamSearch' => $teamSearch]);
        }
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $teamModel = view('admin.teams.create')->render();
        return response()->json(['status' => 'success', 'output' => $teamModel]);
        // return view('admin.teams.create');
    }

    public function store(StoreTeamRequest $request)
    {
        $team = Team::create($request->all());
        $teams = Team::latest()->paginate(config('app.paginate'));
        $teamTable = view('admin.teams.teamtable', compact('teams'))->render();
        return response()->json(['status' => 'success', 'message' => 'Organization added successfully !', 'output' => $teamTable]);
        // return redirect()->route('admin.teams.index')->with(['success' => 'Team Created Successfully']);
    }

    public function edit(Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');      
        $teamModel = view('admin.teams.edit', compact('team'))->render();
        return response()->json(['status' => 'success', 'output' => $teamModel]);
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->all());
        $teams = Team::latest()->paginate(config('app.paginate'));
        $teamTable = view('admin.teams.teamtable', compact('teams'))->render();
        return response()->json(['status' => 'success', 'message' => 'Organization updated successfully !', 'output' => $teamTable]);

    }

    public function show(Team $team)
    {
        abort_if(Gate::denies('team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.teams.show', compact('team'));
    }

    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $team->delete();
        $teams = Team::latest()->paginate(config('app.paginate'));
        $teamTable = view('admin.teams.teamtable', compact('teams'))->render();
        return response()->json(['status' => 'success', 'message' => 'Organization delete successfully !', 'output' => $teamTable]);
    }

    public function massDestroy(MassDestroyTeamRequest $request)
    {
        Team::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
