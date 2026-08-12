<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar seluruh task
     */
    public function index(Request $request)
    {
        try {
            $query = Task::with(['pdUser', 'qaUser', 'plannerUser', 'itemSpecs', 'timelines']);

            // Filter berdasarkan status jika ada query string ?status=
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan pencarian item_code atau project_name
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('item_code', 'like', "%{$search}%")
                      ->orWhere('project_name', 'like', "%{$search}%")
                      ->orWhere('no', 'like', "%{$search}%");
                });
            }

            $tasks = $query->latest()->get();

            return response()->json([
                'status'  => 'success',
                'message' => 'Tasks retrieved successfully',
                'data'    => $tasks
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to retrieve tasks: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail single task berdasarkan ID
     */
    public function show($id)
    {
        try {
            $task = Task::with(['pdUser', 'qaUser', 'plannerUser', 'itemSpecs', 'timelines'])->find($id);

            if (!$task) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Task not found'
                ], 404);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Task details retrieved successfully',
                'data'    => $task
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch task details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Membuat Task Baru dari Mobile / API
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code'    => 'required|string',
            'project_name' => 'required|string',
            'market'       => 'nullable|string',
            'brand_family' => 'nullable|string',
            'customer'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate nomor task otomatis jika tidak diisi
            $lastTask = Task::latest('id')->first();
            $nextNumber = $lastTask ? $lastTask->id + 1 : 1;
            $generatedNo = 'CREATTASK' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $taskData = array_merge($request->all(), [
                'no' => $request->no ?? $generatedNo,
                'status' => $request->status ?? 'todo',
                'development_status' => $request->development_status ?? 'Active',
            ]);

            $task = Task::create($taskData);

            return response()->json([
                'status'  => 'success',
                'message' => 'Task created successfully',
                'data'    => $task
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create task: ' . $e->getMessage()
            ], 500);
        }
    }
}