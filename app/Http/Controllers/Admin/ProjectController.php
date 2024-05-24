<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Functions\Helper;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(10);

        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $form_data=$request->all();

        if (array_key_exists('image',$form_data)) {
           $image_path=Storage::put('uploads',$form_data['image']);
           $original_name=$request->file('image')->getClientOriginalName();
           $form_data['image']=$image_path;
           $form_data['image_original_name']=$original_name;
        }
        $form_data['slug']=Helper::generateSlug($form_data['name'], new Project());
        $new_project= new Project();
        $new_project->fill($form_data);
        $new_project->save();

        return redirect()->route('admin.projects.show',$new_project);

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $form_data=$request->all();

        if ($form_data['name']!= $project->name) {
            $form_data['slug']=Helper::generateSlug($form_data['name'],Project::class);
        } else {
            $form_data['slug']= $project->slug;
        }
        if (array_key_exists('image',$form_data)) {
            $image_path=Storage::put('uploads',$form_data['image']);
            $original_name=$request->file('image')->getClientOriginalName();
            $form_data['image']=$image_path;
            $form_data['image_original_name']=$original_name;
        }

        $project->update($form_data);

        return redirect()->route('admin.projects.show',$project);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {

            Storage::disk('public')->delete($project->image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('cancel', 'Il fumetto '. $project->name .' è stato eliminato con successo!');
    }
}
