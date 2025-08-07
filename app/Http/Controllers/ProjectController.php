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
      $keyword = str($request->remark_filter);
      if ($keyword === 'Approved') {
        $query->whereRaw("(remarks) = 'Approved'");
      } elseif ($keyword === 'On Progress') {
        $query->whereRaw("(remarks) LIKE 'On Progress%'");
      } elseif ($keyword === 'Pending') {
        $query->whereRaw("(remarks) LIKE 'Pending%'");
      } elseif ($keyword === 'Cancel') {
        $query->whereRaw("(remarks) LIKE = 'Cancel%'");
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
              <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z" />
            </svg>
          </a>
          <a href="' . $editUrl . '" title="Edit" class="bg-yellow-50 p-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M12 20h9" />
              <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19.5 3 21l1.5-4L16.5 3.5z" />
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
  public function show(Project $project)
  {
    return view('dashboard.projects.show', compact('project'));
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
