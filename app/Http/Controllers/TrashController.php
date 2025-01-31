<?php

namespace App\Http\Controllers;

use App\Trash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class TrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trash = Trash::paginate(5);
        return view('folder.index', compact('trash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('folder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = Trash::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('trash.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Trash::findorfail($id);
        $hapus->delete();

        return redirect()->back()->with('success', 'Data berhasil ditrash');
    }

    public function tampil_hapus()
    {
        $trash = Trash::onlyTrashed()->paginate(5);
        return view('folder.hapus', compact('trash'));
    }

    public function restore($id)
    {
        $trash = Trash::withTrashed()->where('id', $id)->first();
        $trash->restore();
        return redirect()->route('trash.index')->with('success', 'Data berhasil direstore');
    }

    public function hapus_permanent($id)
    {
        $trash = Trash::withTrashed()->where('id', $id)->first();
        $trash->forceDelete();

        return redirect()->back()->with('success', 'Data berhasil dihapus secara permanent');
    }
}
