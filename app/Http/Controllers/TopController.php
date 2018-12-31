<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;

class TopController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return view('top.index');
    }

    public function create(Request $request) {
        $this->validate($request, [
            'image' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
                // 最小縦横120px 最大縦横400px
                // 'dimensions:min_width=120,min_height=120,max_width=400,max_height=400',
            ]
        ]);
        if ($request->file('image')->isValid()) {
            // 画像ファイルの保存 & 背景透過
            $imageFilename = $request->image->store('images/result');
            $outputFileFullPath = $this->imageService->convertImage($imageFilename);
            $this->imageService->trimImageWhitespace($outputFileFullPath);

            return view('top.create')->with([
                'imageUrl' => basename($outputFileFullPath),
            ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['image' => '画像がアップロードされていないか不正なデータです。']);
        }
    }
}
