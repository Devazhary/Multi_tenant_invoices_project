<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $validatedData = $request->validated();
        $section = Section::create($validatedData);
        if ($section) {
            return redirect()->back()->with('success', 'تم إضافة القسم بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة القسم');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section)
    {
        $validatedData = $request->validated();
        $updated = $section->update($validatedData);

        if ($updated) {
            return redirect()->back()->with('success', 'تم تعديل القسم بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل القسم');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $deleted = $section->delete();
        if ($deleted) {
            return redirect()->back()->with('success', 'تم حذف القسم بنجاح');
        }
        return redirect()->back()->with('error', 'حدث خطأ أثناء حذف القسم');
        
    }
}
