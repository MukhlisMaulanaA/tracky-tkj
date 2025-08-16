@extends('layouts.dashboard')

@section('title', 'Edit Project')

@section('content')
  <div class="max-w-4xl mx-auto">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Edit Project</h1>
      <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali</a>
    </header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <form action="{{ route('projects.update', $project->id_project) }}" method="POST">
        @csrf
        @method('PUT')

        @include('dashboard.projects.partials.form-fields', ['project' => $project])

        <div class="mt-6 flex justify-end space-x-3">
          <a href="{{ route('projects.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm">Cancel</a>
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm">Update Project</button>
        </div>
      </form>
    </div>
  </div>
@endsection
