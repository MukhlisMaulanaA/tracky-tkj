<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return view('dashboard.projects.index');
  }
  /**
   * Datatable endpoint for projects
   */
  public function datatable(Request $request)
  {
    $query = Project::query();

    if ($request->has('remark_filter') && $request->remark_filter !== '') {
      $keyword = strtoupper($request->remark_filter);
      if ($keyword === 'APPROVED') {
        $query->whereRaw("UPPER(remarks) = 'APPROVED'");
      } elseif ($keyword === 'PROGRESS') {
        $query->whereRaw("UPPER(remarks) LIKE 'PROGRESS%'");
      } elseif ($keyword === 'PENDING') {
        $query->whereRaw("UPPER(remarks) LIKE 'PENDING%'");
      } elseif ($keyword === 'CANCEL') {
        $query->whereRaw("UPPER(remarks) LIKE 'CANCEL%'");
      }
    }

    return \Yajra\DataTables\Facades\DataTables::of($query)
      ->addColumn('action', function ($row) {
        $editUrl = route('projects.edit', $row->id_project);
        $deleteUrl = route('projects.destroy', $row->id_project);
        $showUrl = route('projects.show', $row->id_project);
        return '
        <div class="flex items-center space-x-3">
          <a href="' . $showUrl . '" title="Lihat Detail" class="bg-blue-50 p-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M9 12h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2h-6.586A2 2 0 008.586 4L6 6.586A2 2 0 004 8.586V17a2 2 0 002 2h8a2 2 0 002-2v-3" />
            </svg>
          </a>
          <a href="' . $editUrl . '" title="Edit" class="bg-green-50 p-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z" />
            </svg>
          </a>
          <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Hapus project ini?\')" class="bg-red-50 p-1 rounded inline">
            ' . csrf_field() . method_field('DELETE') . '
            <button type="submit" title="Hapus Project">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </form>
        </div>';
      })
      ->rawColumns(['action'])
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.projects.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'id_project' => 'required|unique:projects,id_project',
      'project_name' => 'required',
      'customer_name' => 'required',
      'year' => 'required|integer',
      'nomor_po' => 'required',
    ]);
    Project::create($request->all());
    return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Project $project, string $id_project)
  {
    $project = Project::where('id_project', $id_project)->firstOrFail();
    return response()->json([
      'customer_name' => $project->customer_name,
      'project_name' => $project->project_name,
      'nomor_po' => $project->nomor_po,
      'year' => $project->created_at ? $project->created_at->format('Y') : null,
    ]);
  }
  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Project $project)
  {
    return view('dashboard.projects.edit', compact('project'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Project $project)
  {
    $request->validate([
      'project_name' => 'required',
      'customer_name' => 'required',
      'year' => 'required|integer',
      'nomor_po' => 'required',
    ]);
    $project->update($request->all());
    return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Project $project)
  {
    $project->delete();
    return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
  }
}
