<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Photo;
use Image;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(20);
        return view('backend.photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|min:3|max:120',
            'description'=>'required|min:3|max:200',
            'image'=>'required|mimes:jpeg,jpg,png'
        ]);
        $image = $request->file('image');
        $filename = $image->hashName();
        $size = $request->image->getSize();
        $format = $request->image->getClientOriginalExtension();
        $path = 'uploads/'.$filename;
        $path1 = 'uploads/1280x1024/'.$filename;
        $path2 = 'uploads/315x255/'.$filename;
        $path3 = 'uploads/118x95/'.$filename;
        Image::make($image->getRealPath())->resize(800,600)->save($path);
        Image::make($image->getRealPath())->resize(1280,1024)->save($path1);
        Image::make($image->getRealPath())->resize(315,255)->save($path2);
        Image::make($image->getRealPath())->resize(118,95)->save($path3);
        $photo = new Photo;
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->file = $filename;
        $photo->format = $format;
        $photo->size = $size;
        $photo->save();
        return redirect()->back()->with('message','Photo uploaded successfully!');
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
        $photo = Photo::find($id);
        return view('backend.photos.edit', compact('photo'));
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
        $this->validate($request,[
            'title'=>'required|min:3|max:100',
            'description'=>'required|min:3|max:500'
        ]);

        $photo = Photo::find($id);
        $fileName = $photo->file;
        $format = $photo->format;
        $size = $photo->size;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $newFilename = $image->hashName();
            $size = $request->image->getSize();
            $format = $request->image->getClientOriginalExtension();
            $path = 'uploads/'.$newFilename;
            $path1 = 'uploads/1280x1024/'.$newFilename;
            $path2 = 'uploads/315x255/'.$newFilename;
            $path3 = 'uploads/118x95/'.$newFilename;
            Image::make($image->getRealPath())->resize(800,600)->save($path);
            Image::make($image->getRealPath())->resize(1280,1024)->save($path1);
            Image::make($image->getRealPath())->resize(315,255)->save($path2);
            Image::make($image->getRealPath())->resize(118,95)->save($path3);
            unlink(public_path('/uploads/'.$photo->file));
            unlink(public_path('/uploads/1280x1024/'.$photo->file));
            unlink(public_path('/uploads/315x255/'.$photo->file));
            unlink(public_path('/uploads/118x95/'.$photo->file)); 
            $photo->title = $request->get('title');
            $photo->description = $request->get('description');
            $photo->format = $format;
            $photo->size = $size;
            $photo->file = $newFilename;
            
            $photo->save();
            return redirect()->back()->with('message', 'Photo updated successfully!');   
        }
        $photo->title = $request->get('title');
        $photo->description = $request->get('description');
        $photo->format = $format;
        $photo->size = $size;
        $photo->file = $fileName;
        
        $photo->save();
        return redirect()->back()->with('message', 'Photo updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        $photo->delete();
        unlink(public_path('/uploads/'.$photo->file));
        unlink(public_path('/uploads/1280x1024/'.$photo->file));
        unlink(public_path('/uploads/315x255/'.$photo->file));
        unlink(public_path('/uploads/118x95/'.$photo->file));        
        return redirect()->back()->with('message', 'Photo deleted successfully!');
    }
}
