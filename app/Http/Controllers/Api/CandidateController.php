<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Candidate;
use App\Traits\FileHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    use FileHandlerTrait;

    private function getCandidateById($id)
    {
        $candidate = Candidate::whereId($id)->whereNull('deleted_at')->first();

        if (!$candidate) {
            return $this->responseError('not_found');
        }
        return $candidate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $search = $request->query('q') ? '%' . $request->query('q') . '%' : null;
        $orderBy = $request->query('order_by');
        $orderType = $request->query('order_type', 'asc');

        // menggunakan query builder
        $candidateModel = DB::table('candidates')->whereNull('deleted_at');

        $candidates = $candidateModel->when($search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', $search)
                        ->orWhere('education', 'like', $search)
                        ->orWhere('last_position', 'like', $search)
                        ->orWhere('applied_position', 'like', $search)
                        ->orWhere('top_skills', 'like', $search)
                        ->orWhere('email', 'like', $search);
                });
            })
            ->select(
                '*'
            )
            ->when(($orderBy), function ($q) use ($orderType, $orderBy) {
                $q->orderBy($orderBy, $orderType);
            });

        $totalData = $candidateModel->count();

        $candidates = $candidates->when(($perPage !== null && $page !== null), function ($q) use ($perPage, $page) {
            $offset = ($page - 1) * $perPage;
            $q->offset($offset)
                ->limit($perPage);
        })->get();

        return $this->responseSuccess('get_data', ['data' => [
            'total' => $totalData,
            'candidates' => $candidates,
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|max:191',
        'education' => 'nullable',
        'date_of_birth' => 'required|date_format:Y-m-d',
        'experience' => 'nullable',
        'last_position' => 'nullable',
        'applied_position' => 'nullable',
        'top_skills' => 'nullable',
        'phone_number' => 'required|max:15|unique:candidates,phone_number',
        'email' => 'required|unique:candidates,email',
        'resume' => 'nullable|file|mimes:pdf|max:5124',
    ]);

        $candidate = new Candidate();

        if ($request->resume) {
            $candidate->resume = $this->uploadFile($request->file('resume'), 'resumes', $candidate->id);
        }

        $candidate->fill($request->except('resume'));
        $candidate->save();

        return $this->responseSuccess('store_data', ['data' => $candidate]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $candidate = Candidate::whereId($id)->whereNull('deleted_at')->first();

        if (!$candidate) {
            return $this->responseError('not_found');
        }

        return $this->responseSuccess('get_data', ['data' => $candidate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $candidate = Candidate::whereId($id)->whereNull('deleted_at')->first();

        if (!$candidate) {
            return $this->responseError('not_found');
        }

        $request->validate([
            'name' => 'required|max:191',
            'education' => 'nullable',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'experience' => 'nullable',
            'last_position' => 'nullable',
            'applied_position' => 'nullable',
            'top_skills' => 'nullable',
            'phone_number' => 'required|max:15|unique:candidates,phone_number,'.$id,
            'email' => 'required|unique:candidates,email,'.$id,
            'resume' => 'nullable|file|mimes:pdf|max:5124',
        ]);

        if ($request->resume) {
            $candidate->resume = $this->uploadFile($request->file('resume'), 'resumes', $candidate->id);
        }

        $candidate->fill($request->except('resume'));
        $candidate->update();

        return $this->responseSuccess('update_data', ['data' => $candidate->fresh()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate = Candidate::whereId($id)->whereNull('deleted_at')->first();

        if (!$candidate) {
            return $this->responseError('not_found');
        }

        $candidate->delete();

        return $this->responseSuccess('delete_data', ['data' => $candidate]);
    }
}
