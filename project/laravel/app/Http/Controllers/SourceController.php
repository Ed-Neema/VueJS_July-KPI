<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Source;
use App\Actions\Search;
use Illuminate\Http\Request;
use App\Http\Requests\SourceRequest;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sources = [];
        if (empty($request->data)) {
            $sources = Source::orderBy('id', 'desc')
            ->where('company_id', $request->user()->company->id)
            ->paginate(10);
        }

        if (! empty($request->data)) {
            $sources = (new Search)('App\Models\Source', $request->data, null, null, $request->user()->company->id);
        }

        $typeOptions = Source::getTypeOptions();
        $statusOptions = Source::getStatusOptions();

        return Inertia::render('Sources', [
            'sources' => $sources,
            'typeOptions' => $typeOptions,
            'statusOptions' => $statusOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SourceRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SourceRequest $request)
    {
        Source::create([
            'name' => $request['name'],
            'company_id' => $request->user()->company->id,
            'type' => $request['type'],
            'domain' => $request['domain'],
            'status' => $request['status'],
        ]);

        return redirect()->route('sources.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SourceRequest  $request
     * @param  \App\Models\Source  $source
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SourceRequest $request, Source $source)
    {
        $source->update($request->all());

        return redirect()->route('sources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Source $source)
    {
        $source->delete();

        return redirect()->route('sources.index');
    }
}
