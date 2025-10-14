@extends('layouts.app')

@section('title', 'Student List')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Student List</h1>
        <a href="{{ route('admin.students.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-900 to-slate-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
           + Add Student
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <table id="studentsTable" class="display w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.students.data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: "class_name", title: "Class" },
            { data: 'email', name: 'email' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
