<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $query = Project::orderByDesc('updated_at')->orderByDesc('created_at');

        if ($filter) {
            $value = $filter === 'published';
            $query->whereIsPublished($value);
        }

        $projects = $query->paginate(7)->withQueryString();
        return view('admin.projects.index', compact('projects', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        return view('admin.projects.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:50|unique:projects',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Il titolo e\' obbligatorio',
            'title.unique' => 'Questo titolo e\' gia\' stato utilizzato',
            'title.min' => 'Il titolo deve essere almeno :min caratteri',
            'title.max' => 'Il titolo deve essere massimo :max caratteri',
            'image.image' => 'Il file inserito non e\' un immagine',
            'image.image' => 'Le estensioni valide sono .png, .jpg, .jpeg',
            'is_published.boolean' => 'Il valore del campo pubblicazione non e\' valido',
            'content.required' => 'La descrizione e\' obblogatoria',
        ]);

        $data = $request->all();

        $project = new Project();

        $project->fill($data);
        $project->slug = Str::slug($project['title']);
        $project->is_published = Arr::exists($data, 'is_published');

        //Controllo se arriva un file
        if (Arr::exists($data, 'image')) {
            $extension = $data['image']->extension();

            //salvo e prendo l'url
            $img_url = Storage::putFile('project_images', $data['image'], "$project->slug.$extension");
            $project->image = $img_url;
        }

        $project->save();

        return to_route('admin.projects.show', $project)->with('message', 'Progetto creato con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
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
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:50', Rule::unique('projects')->ignore($project->id)],
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Il titolo e\' obbligatorio',
            'title.unique' => 'Questo titolo e\' gia\' stato utilizzato',
            'title.min' => 'Il titolo deve essere almeno :min caratteri',
            'title.max' => 'Il titolo deve essere massimo :max caratteri',
            'image.image' => 'Il file inserito non e\' un immagine',
            'image.image' => 'Le estensioni valide sono .png, .jpg, .jpeg',
            'is_published.boolean' => 'Il valore del campo pubblicazione non e\' valido',
            'content.required' => 'La descrizione e\' obblogatoria',
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = Arr::exists($data, 'is_published');

        //Controllo se arriva un file
        if (Arr::exists($data, 'image')) {
            //controllo se aveva gia' immagine
            if ($project->image) Storage::delete($project->image);

            //salvo e prendo l'url
            $extension = $data['image']->extension();
            $img_url = Storage::putFile('project_images', $data['image'], "{$data['slug']} .$extension");
            $project->image = $img_url;
        }

        $project->update($data);

        return to_route('admin.projects.show', $project)->with('message', 'Progetto modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Progetto eliminato con successo');
    }

    // Rotte SOFT DELETE 

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }

    public function restore(Project $project)
    {
        $project->restore();

        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Progetto ripubblicato con successo');
    }

    public function drop(Project $project)
    {
        //controllo se aveva gia' immagine
        if ($project->image) Storage::delete($project->image);

        $project->forceDelete();

        return to_route('admin.projects.trash')->with('type', 'success')->with('message', 'Eleminato definitivamente');
    }

    // Rotta pubblicazione
    public function togglePublication(Project $project)
    {
        $project->is_published = !$project->is_published;
        $project->save();

        $action = $project->is_published ? 'pubblicato' : 'salvato come bozza';

        //torna da chi ti ha chiamato
        return back()->with('message', "Il progetto $project->title e\' stato $action")->with('type', 'success');
    }
}
