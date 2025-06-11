<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcademyController extends Controller
{
public function index()
{
    // Pega categorias para o select
    $categories = DB::table('video_categories')
        ->orderBy('name')
        ->get();

    // Pega todos os vídeos (+ nome da categoria)
    $videos = DB::table('videos')
        ->join('video_categories', 'videos.category_id', '=', 'video_categories.id')
        ->select('videos.*', 'video_categories.name as category_name')
        ->orderBy('position')
        ->get();

    return view('academy.index', compact('categories', 'videos'));
}

    public function videoCategoriesIndex()
    {
        $categories = DB::table('video_categories')
            ->orderBy('name')
            ->get();

        return view('video_categories.index', compact('categories'));
    }

    /** Formulário de criação de categoria */
    public function videoCategoriesCreate()
    {
        return view('video_categories.create');
    }

    /** Gravar nova categoria */
    public function videoCategoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:video_categories,name'
        ]);

        DB::table('video_categories')->insert([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('video-categories.index')
            ->with('success', 'Categoria criada com sucesso.');
    }

    /** Formulário de edição de categoria */
    public function videoCategoriesEdit($id)
    {
        $category = DB::table('video_categories')->find($id);

        return view('video_categories.edit', compact('category'));
    }

    /** Atualizar categoria */
    public function videoCategoriesUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => "required|string|unique:video_categories,name,{$id}"
        ]);

        DB::table('video_categories')
            ->where('id', $id)
            ->update([
                'name'       => $request->name,
                'slug'       => Str::slug($request->name),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('video-categories.index')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    /** Remover categoria */
    public function videoCategoriesDestroy($id)
    {
        DB::table('video_categories')->where('id', $id)->delete();

        return redirect()
            ->route('video-categories.index')
            ->with('success', 'Categoria removida.');
    }


    //───────────────────────────────────────────────────────────
    // VÍDEOS
    //───────────────────────────────────────────────────────────

    /** Listar vídeos */
    public function videosIndex()
    {
        $videos = DB::table('videos')
            ->join('video_categories', 'videos.category_id', '=', 'video_categories.id')
            ->select('videos.*', 'video_categories.name as category_name')
            ->orderBy('position')
            ->get();

        return view('videos.index', compact('videos'));
    }

    /** Formulário de upload de vídeo */
    public function videosCreate()
    {
        $categories = DB::table('video_categories')
            ->orderBy('name')
            ->get();

        return view('videos.create', compact('categories'));
    }

    /** Gravar novo vídeo */
public function videosStore(Request $request)
{
    // 1) Antes de validar, confirme que o PHP recebeu o upload
    if (! $request->hasFile('thumbnail')) {
        return response()->json([
            'message' => 'Nenhum arquivo de thumbnail foi enviado.',
            'errors'  => ['thumbnail' => ['Nenhum arquivo recebido.']]
        ], 422);
    }

    $thumb = $request->file('thumbnail');

    if (! $thumb->isValid()) {
        // detecta tipo de erro do PHP
        $code = $thumb->getError();
        $msg  = match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE
                => 'O arquivo excede o tamanho máximo permitido.',
            UPLOAD_ERR_PARTIAL
                => 'O upload foi interrompido antes de terminar.',
            default
                => 'Falha ao fazer upload da thumbnail.'
        };
        return response()->json([
            'message' => $msg,
            'errors'  => ['thumbnail' => [$msg]]
        ], 422);
    }

    // 2) Validação normal
    $request->validate([
        'title'       => 'required|string|max:255',
        'category_id' => 'required|exists:video_categories,id',
        'video'       => 'required|file|mimetypes:video/mp4,video/avi,video/mov|max:51200',
        'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,webp|max:10240', // até 10 MB
        'is_featured' => 'nullable|boolean',
        'position'    => 'nullable|integer',
    ]);

    // 3) Armazena no disco
    $videoPath = $request->file('video')->store('videos', 'public');
    $thumbPath = $thumb->store('thumbnails', 'public');

    // 4) Persiste no banco
    DB::table('videos')->insert([
        'category_id'    => $request->category_id,
        'title'          => $request->title,
        'slug'           => Str::slug($request->title),
        'video_url'      => $videoPath,
        'thumbnail_path' => $thumbPath,
        'is_featured'    => $request->boolean('is_featured'),
        'position'       => $request->position ?? 0,
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return response()->json([
        'message' => 'Vídeo enviado e salvo com sucesso.'
    ]);
}


    /** Formulário de edição de vídeo */
    public function videosEdit($id)
    {
        $video      = DB::table('videos')->find($id);
        $categories = DB::table('video_categories')->orderBy('name')->get();

        return view('videos.edit', compact('video', 'categories'));
    }

    /** Atualizar vídeo (com troca opcional de arquivo) */
    public function videosUpdate(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:video_categories,id',
            'video'       => 'nullable|file|mimetypes:video/mp4,video/avi,video/mov|max:51200',
            'is_featured' => 'nullable|boolean',
            'position'    => 'nullable|integer',
        ]);

        $data = [
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'is_featured'  => $request->boolean('is_featured'),
            'position'     => $request->position ?? 0,
            'updated_at'   => now(),
        ];

        if ($request->hasFile('video')) {
            // Deleta o arquivo antigo
            $old = DB::table('videos')->where('id', $id)->value('video_url');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            // Faz upload do novo
            $data['video_url'] = $request->file('video')->store('videos', 'public');
        }

        DB::table('videos')->where('id', $id)->update($data);

        return redirect()
            ->route('videos.index')
            ->with('success', 'Vídeo atualizado com sucesso.');
    }

    /** Excluir vídeo e arquivo */
    public function videosDestroy($id)
    {
        $path = DB::table('videos')->where('id', $id)->value('video_url');
        if ($path) {
            Storage::disk('public')->delete($path);
        }
        DB::table('videos')->where('id', $id)->delete();

        return redirect()
            ->route('videos.index')
            ->with('success', 'Vídeo excluído.');
    }

}
